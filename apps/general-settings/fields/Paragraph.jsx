export default function Paragraph( { field, className } ) {
	return (
		<div className={ `modula_field_wrapp ${ className || '' }` }>
			{ field.label && field.label.trim() !== '' && (
				<span className="modula_input_label">
					{ field.label }
				</span>
			) }
			{ field.value && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.value } } />
			) }
		</div>
	);
}
