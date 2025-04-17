import FieldRenderer from '../FieldRenderer';
import ButtonField from './ButtonField';

export function ComboField( { option, field, form, handleChange, className } ) {
	return (
		<>
			{ field.fields.map( ( item, index ) => {
				if ( item.type === 'button' ) {
					return (
						<ButtonField key={ index } field={ item } />
					);
				}

				return (
					<div key={ `${ item.name }-wrapper` } className={ `modula_field_wrapp ${ className || '' }` }>
						<form.Field name={ option ? `${ option }.${ item.name }` : item.name }>
							{ ( fieldState ) => (
								<FieldRenderer
									field={ item }
									fieldState={ fieldState }
									handleChange={ handleChange }
								/>
							) }
						</form.Field>
					</div>
				);
			} ) }
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
