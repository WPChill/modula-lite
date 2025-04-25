import { TextControl } from '@wordpress/components';

export default function TextField( { fieldState, field, handleChange, className, disabled = false } ) {
	return (
		<>
			{ field.label && field.label.trim() !== '' && (
				<span className="modula_input_label" htmlFor={ field.name }>
					{ field.label }
				</span>
			) }
			<TextControl
				type={ field.inputType || 'text' }
				className={ `modula_input_text ${ className || '' }` }
				value={ fieldState.state.value || '' }
				placeholder={ field.placeholder }
				onChange={ ( val ) => handleChange( val ) }
				disabled={ disabled }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
