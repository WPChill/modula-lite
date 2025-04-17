import { TextControl } from '@wordpress/components';

export default function TextField( { fieldState, field, handleChange, className } ) {
	return (
		<>
			<label className="modula_input_label" htmlFor={ field.name }>
				{ field.label }
			</label>
			<TextControl
				type={ field.inputType || 'text' }
				className={ `modula_input_text ${ className || '' }` }
				value={ fieldState.state.value || '' }
				placeholder={ field.placeholder }
				onChange={ ( val ) => handleChange( val ) }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
