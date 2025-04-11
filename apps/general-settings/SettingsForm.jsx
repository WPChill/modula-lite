import { useForm, useStore } from '@tanstack/react-form';
import { useSettingsMutation } from './query/useSettingsMutation';
import FieldRenderer from './FieldRenderer';
import AiSettingsApp from '../settings/ai-settings-app';
import ButtonField from './fields/ButtonField';
import { ComboField } from './fields/ComboField';
import { RoleField } from './fields/RoleField';
import { useEffect, useMemo, useRef } from '@wordpress/element';
import { debounce } from 'lodash';

export default function SettingsForm( { config } ) {
	function setDefaultValue( acc, option, name, defaultValue ) {
		if ( name.includes( '.' ) ) {
			const [ parent, child ] = name.split( '.' );
			acc[ option ] = acc[ option ] || {};
			acc[ option ][ parent ] = acc[ option ][ parent ] || {};
			acc[ option ][ parent ][ child ] = defaultValue ?? '';
		} else if ( option ) {
			acc[ option ] = acc[ option ] || {};
			acc[ option ][ name ] = defaultValue ?? '';
		} else {
			acc[ name ] = defaultValue ?? '';
		}
	}

	const settingsMutation = useSettingsMutation();
	const mutationRef = useRef( settingsMutation );

	useEffect( () => {
		mutationRef.current = settingsMutation;
	}, [ settingsMutation ] );

	const { option, fields = [] } = config;

	const form = useForm( {
		defaultValues: fields.reduce( ( acc, field ) => {
			if ( field.type === 'react_root' || 'undefined' === typeof field.name ) {
				return acc;
			} else if ( ( field.type === 'combo' ) || ( field.type === 'role' ) ) {
				if ( 'undefined' !== typeof field.name && 'undefined' !== typeof field.default ) {
					setDefaultValue( acc, option, field.name, field.default );
				}
				field.fields.forEach( ( comboField ) => {
					setDefaultValue( acc, option, comboField.name, comboField.default );
				} );
			} else {
				setDefaultValue( acc, option, field.name, field.default );
			}
			return acc;
		}, {} ),
	} );

	const storedValues = useStore( form.store, ( state ) => state.values );
	const formValues = option ? storedValues[ option ] || {} : storedValues;

	const debouncedSave = useMemo( () => {
		const fn = debounce( ( opt, val ) => {
			mutationRef.current.mutate( { option: opt, value: val } );
		}, 500 );

		return fn;
	}, [] );

	useEffect( () => {
		return () => {
			debouncedSave.cancel();
		};
	}, [ debouncedSave ] );

	const operators = {
		'===': ( a, b ) => a === b,
		'!==': ( a, b ) => a !== b,
		'>': ( a, b ) => a > b,
		'<': ( a, b ) => a < b,
		'>=': ( a, b ) => a >= b,
		'<=': ( a, b ) => a <= b,
	};

	const evaluateConditions = ( conditions ) => {
		if ( ! conditions ) {
			return true;
		}

		return conditions.every( ( { field, comparison, value } ) => {
			const keys = field.split( '.' );
			let val = formValues;
			for ( const key of keys ) {
				val = val?.[ key ];
			}

			return operators[ comparison ]( val ?? null, value );
		} );
	};

	const handleChange = ( fieldState, fieldName, newValue ) => {
		fieldState.handleChange( newValue );

		const allValues = form.store.state.values;
		const updatedFormValues = option ? allValues[ option ] : allValues;

		if ( fieldName.includes( '.' ) ) {
			const [ parent, child ] = fieldName.split( '.' );
			updatedFormValues[ parent ] = updatedFormValues[ parent ] || {};
			updatedFormValues[ parent ][ child ] = newValue;
		} else {
			updatedFormValues[ fieldName ] = newValue;
		}

		if ( option ) {
			debouncedSave( option, updatedFormValues );
		} else {
			debouncedSave( fieldName, newValue );
		}
	};

	if ( 'modula_ai' === config ) {
		return (
			<AiSettingsApp />
		);
	}

	if ( ! config || ! fields ) {
		return <p>Loading settings...</p>;
	}

	if ( fields.length === 0 ) {
		return <div className="modula_no_settings">⚙️ No settings found.</div>;
	}
	const optionValue = option ? option : 'default';
	return (
		<form className={ `modula_options_form modula_${ optionValue }_form` }>
			{ fields.map( ( field, index ) => {
				if ( ! evaluateConditions( field.conditions ) ) {
					return null;
				}

				if ( field.type === 'react_root' ) {
					return (
						<AiSettingsApp key={ index } />
					);
				}

				if ( field.type === 'combo' ) {
					return (
						<div key={ index } className="modula_field_wrapper">
							<ComboField
								option={ option }
								fields={ field.fields }
								form={ form }
								handleChange={ handleChange }
							/>
						</div>
					);
				}

				if ( field.type === 'role' ) {
					return (
						<div key={ index } className="modula_roles_field_wrapper">
							<RoleField
								option={ option }
								mainField={ field }
								form={ form }
								handleChange={ handleChange }
							/>
						</div>
					);
				}

				if ( field.type === 'button' ) {
					return (
						<div key={ index } className="modula_roles_field_wrapper">
							<ButtonField field={ field } />
						</div>
					);
				}

				if ( field.type === 'upsell' ) {
					return (
						<div key={ index } className="modula_roles_field_wrapper">
							grrr
						</div>
					);
				}
				return (
					<div key={ field.name } className="modula_field_wrapper">
						<div className="modula_field_wrapp">
							<form.Field name={ option ? `${ option }.${ field.name }` : field.name }>
								{ ( fieldState ) => (
									<FieldRenderer
										field={ field }
										fieldState={ fieldState }
										handleChange={ handleChange }
									/>
								) }
							</form.Field>
						</div>
					</div>
				);
			} ) }
		</form>
	);
}
