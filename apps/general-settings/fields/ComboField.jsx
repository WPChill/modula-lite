import FieldRenderer from '../FieldRenderer';
import ButtonField from './ButtonField';

export function ComboField( { option, field, form, handleChange, className, evaluateConditions } ) {
	return (
		<>
			{ field.fields.map( ( item, index ) => {
				const isVisible = evaluateConditions( item.conditions );

				if ( item.type === 'button' ) {
					return (
						<ButtonField key={ index } field={ item } disabled={ ! isVisible } />
					);
				}

				return (
					<div key={ `${ item.name }-wrapper` } className={ `modula_field_wrapp ${ className || '' } ${ ! isVisible ? 'modula-disabled' : '' }` }>
						<form.Field name={ option ? `${ option }.${ item.name }` : item.name }>
							{ ( fieldState ) => (
								<FieldRenderer
									field={ item }
									fieldState={ fieldState }
									handleChange={ handleChange }
									disabled={ ! isVisible }
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
