import { SelectControl } from '@wordpress/components';

export default function SelectField( { fieldState, field, handleChange, className } ) {
	return (
		<>
			<label className="modula_input_label" htmlFor={ field.name }>
				{ field.label }
			</label>
			<SelectControl
				className={ `modula_input_select ${ className || '' }` }
				value={ fieldState.state.value }
				options={ field.options.map( ( option ) => ( { label: option.label, value: option.value } ) ) }
				onChange={ ( val ) => handleChange( val ) }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
