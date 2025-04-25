import { TextControl } from '@wordpress/components';

export default function NumberField( { fieldState, field, handleChange, className } ) {
	return (
		<>
			{ field.label && field.label.trim() !== '' && (
				<span className="modula_input_label" htmlFor={ field.name }>
					{ field.label }
				</span>
			) }
			<TextControl
				type="number"
				className={ `modula_input_text ${ className || '' }` }
				min={ field.min }
				max={ field.max }
				value={ fieldState.state.value }
				onChange={ ( val ) => handleChange( val ) }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
