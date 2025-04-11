import { Button } from '@wordpress/components';

export default function ButtonField( { field, className, variant = 'primary' } ) {
	return (
		<>
			<span className="modula_input_label">
				{ field.label }
			</span>
			<Button href={ field.href } variant={ variant } className={ `modula_field_wrapp ${ className || '' }` }>
				{ field.text }
			</Button>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
