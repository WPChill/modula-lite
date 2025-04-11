import { useState } from '@wordpress/element';
import ToggleField from './ToggleField';
import {
	Card,
	CardBody,
	CardHeader,
} from '@wordpress/components';
import styles from './RoleField.module.scss';

export function RoleField( { option, mainField, form, handleChange } ) {
	const [ enabled, setEnabled ] = useState( mainField.default );

	const onMainToggleChange = ( fieldState, fieldName, val ) => {
		setEnabled( val );

		// set each child-field value based on parent.
		mainField.fields.forEach( ( field ) => {
			const fullFieldName = option ? `${ option }.${ field.name }` : field.name;
			form.setFieldValue( fullFieldName, val );
		} );

		handleChange( fieldState, fieldName, val );
	};

	return (
		<Card className={ `static-class ${ styles.modulaRoleFieldCard }` }>
			<CardHeader className={ `static-class-head ${ styles.modulaRoleFieldCardHead }` }>
				<form.Field key={ `${ mainField.name }-field` } name={ option ? `${ option }.${ mainField.name }` : mainField.name }>
					{ ( fieldState ) => (
						<ToggleField
							fieldState={ fieldState }
							field={ mainField }
							className={ styles.modulaRoleHeadToggle }
							handleChange={ ( val ) =>
								onMainToggleChange( fieldState, mainField.name, val )
							}
						/>
					) }
				</form.Field>
			</CardHeader>
			<CardBody className={ `static-class-body ${ styles.modulaRoleFieldCardBody }` }>
				{ mainField.fields.map( ( field ) => (
					<div key={ `${ field.name }-wrapper` } className="modula_role_field_wrapp">
						<form.Field key={ `${ field.name }-field` } name={ option ? `${ option }.${ field.name }` : field.name }>
							{ ( fieldState ) => (
								<ToggleField
									fieldState={ fieldState }
									field={ field }
									className={ styles.modulaRoleBodyToggle }
									handleChange={ ( val ) => handleChange( fieldState, field.name, val ) }
									disabled={ ! enabled }
								/>
							) }
						</form.Field>
					</div>
				) ) }
			</CardBody>
		</Card>
	);
}
