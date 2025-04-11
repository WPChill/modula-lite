import { RangeControl } from '@wordpress/components';

export default function TextField( { fieldState, field, handleChange, className } ) {
	return (
		<>
			<label className="modula_input_label" htmlFor={ field.name }>
				{ field.label }
			</label>
			<RangeControl
				className={ `modula_input_range ${ className || '' }` }
				initialPosition={ fieldState.state.value }
				value={ fieldState.state.value }
				onChange={ ( val ) => handleChange( val ) }
				max={ field?.max || 100 }
				min={ field?.min || 0 }
			/>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
