import { TextareaControl } from '@wordpress/components';

export default function TextareaField( { fieldState, field, handleChange, className } ) {
	return (
		<>
			{ field.label && field.label.trim() !== '' && (
				<span className="modula_input_label" htmlFor={ field.name }>
					{ field.label }
				</span>
			) }
			<TextareaControl
				className={ `modula_input_text ${ className || '' }` }
				value={ fieldState.state.value }
				onChange={ ( val ) => handleChange( val ) }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
