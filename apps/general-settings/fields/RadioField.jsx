import { RadioControl } from '@wordpress/components';

export default function RadioField( { fieldState, field, handleChange, className } ) {
	return (
		<>
			<label className="modula_input_label" htmlFor={ field.name }>
				{ field.label }
			</label>
			<RadioControl
				className={ `modula_input_radio ${ className || '' }` }
				selected={ fieldState.state.value }
				options={ field.options.map( ( option ) => ( { label: option, value: option } ) ) }
				onChange={ ( val ) => handleChange( val ) }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
