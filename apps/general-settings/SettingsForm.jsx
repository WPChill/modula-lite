import { useForm, useStore } from '@tanstack/react-form';
import FieldRenderer from './FieldRenderer';
import AiSettingsForm from './ai-settings/ai-settings-form';
import ButtonField from './fields/ButtonField';
import Paragraph from './fields/Paragraph';
import { ComboField } from './fields/ComboField';
import { RoleField } from './fields/RoleField';
import UpsellBlock from './UpsellBlock';
import RolesToggle from './RolesToggle';
import useStateContext from './context/useStateContext';
import { setOptions } from './context/actions';

export default function SettingsForm( { config } ) {
	const { state, dispatch } = useStateContext();

	function setDefaultValue( acc, option, name, defaultValue ) {
		if ( ! name ) {
			return acc;
		}

		if ( name.includes( '.' ) ) {
			const [ parent, child ] = name.split( '.' );
			if ( option ) {
				acc[ option ] = acc[ option ] || {};
				acc[ option ][ parent ] = acc[ option ][ parent ] || {};
				acc[ option ][ parent ][ child ] = defaultValue ?? '';
			} else {
				acc[ parent ] = acc[ parent ] || {};
				acc[ parent ][ child ] = defaultValue ?? '';
			}
		} else if ( option ) {
			acc[ option ] = acc[ option ] || {};
			acc[ option ][ name ] = defaultValue ?? '';
		} else {
			acc[ name ] = defaultValue ?? '';
		}
	}

	const { option, fields = [] } = config;

	const form = useForm( {
		defaultValues: fields.reduce( ( acc, field ) => {
			switch ( field.type ) {
				case 'combo':
					field.fields.forEach( ( comboField ) => {
						setDefaultValue( acc, option, comboField.name, comboField.default );
					} );
					break;
				case 'role':
					// Enable role field
					setDefaultValue( acc, option, field.name, field.default );
					// Capabilities
					field.fields.forEach( ( comboField ) => {
						setDefaultValue( acc, option, comboField.name, comboField.default );
					} );
					break;

				case 'button':
				case 'paragraph':
					// We skip these
					break;

				default:
					setDefaultValue( acc, option, field.name, field.default );
					break;
			}

			return acc;
		}, {} ),
	} );

	const values = form.store.state.values;
	const formValues = option ? values[ option ] || {} : values;

	const handleSave = ( opt, val ) => {
		dispatch(
			setOptions( {
				...state.options,
				[ opt ]: val,
			} ),
		);
	};

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
		const updatedFormValues = option ? { ...allValues[ option ] } : { ...allValues };

		if ( fieldName.includes( '.' ) ) {
			const [ parent, child ] = fieldName.split( '.' );
			updatedFormValues[ parent ] = updatedFormValues[ parent ] || {};
			updatedFormValues[ parent ][ child ] = newValue;
		} else {
			updatedFormValues[ fieldName ] = newValue;
		}

		if ( option ) {
			handleSave( option, updatedFormValues );
		} else if ( fieldName.includes( '.' ) ) {
			const [ parent ] = fieldName.split( '.' );
			handleSave( parent, updatedFormValues[ parent ] );
		} else {
			handleSave( fieldName, newValue );
		}
	};

	const activeToggle = useStore( form.store, ( statex ) => statex.values.activeToggle ) || '';

	if ( ! config || ! fields ) {
		return <p>Loading settings...</p>;
	}

	if ( fields.length === 0 ) {
		return <div className="modula_no_settings">⚙️ No settings found.</div>;
	}

	const optionValue = option ? option : 'default';
	return (
		<>
			<form className={ `modula_options_form modula_${ optionValue }_form` }>
				{ config.submenu && <RolesToggle form={ form } submenu={ config.submenu } /> }
				{ fields.map( ( field, index ) => {
					if ( ! evaluateConditions( field.conditions ) ) {
						return null;
					}

					if ( field.type === 'role' ) {
						return (
							<RoleField
								key={ index }
								option={ option }
								mainField={ field }
								form={ form }
								handleChange={ handleChange }
							/>
						);
					}

					if ( field.group && field.group !== activeToggle ) {
						return null;
					}

					if ( field.type === 'modula_ai' ) {
						return (
							<AiSettingsForm key={ index } />
						);
					}

					if ( field.type === 'combo' ) {
						return (
							<div key={ index } className="modula_field_wrapper">
								<ComboField
									option={ option }
									field={ field }
									form={ form }
									handleChange={ handleChange }
								/>
							</div>
						);
					}

					if ( field.type === 'button' ) {
						return (
							<div key={ index } className="modula_field_wrapper">
								<ButtonField field={ field } />
							</div>
						);
					}

					if ( field.type === 'paragraph' ) {
						return (
							<div key={ index } className="modula_field_wrapper">
								<Paragraph field={ field } />
							</div>
						);
					}

					if ( field.type === 'upsell' ) {
						return (
							<UpsellBlock key={ index } field={ field } />
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
		</>
	);
}
