import FieldRenderer from '../FieldRenderer';

export function ComboField( { option, fields, form, handleChange, className } ) {
	return (
		<>
			{ fields.map( ( field ) => (
				<div key={ `${ field.name }-wrapper` } className={ `modula_field_wrapp ${ className || '' }` }>
					<form.Field key={ `${ field.name }-field` } name={ option ? `${ option }.${ field.name }` : field.name }>
						{ ( fieldState ) => (
							<FieldRenderer
								field={ field }
								fieldState={ fieldState }
								handleChange={ handleChange }
							/>
						) }
					</form.Field>
				</div>
			) ) }
		</>
	);
}
