import { useCallback } from '@wordpress/element';
import styles from './checkboxGroupField.module.scss';
import { __ } from '@wordpress/i18n';

export default function CheckboxGroupField( { fieldState, field, handleChange, className } ) {
	const { options, name } = field;
	const selectedValues = fieldState.state.value || [];

	const isSelected = ( value ) => selectedValues.includes( value );

	const toggleCheckbox = ( value ) => {
		if ( isSelected( value ) ) {
			handleChange( selectedValues.filter( ( v ) => v !== value ) );
		} else {
			handleChange( [ ...selectedValues, value ] );
		}
	};

	const selectAll = useCallback( () => {
		const allValues = options.map( ( opt ) => opt.value );
		handleChange( allValues );
	}, [ options, handleChange ] );

	const deselectAll = useCallback( () => {
		handleChange( [] );
	}, [ handleChange ] );

	return (
		<div className={ `${ styles.modulaCheckboxGroup } ${ className || '' }` }>
			<div className={ styles.modulaCheckboxGroupControls }>
				<button type="button" onClick={ selectAll } className={ styles.controlButton }>{ __( 'Select All', 'modula-best-grid-gallery' ) }</button>
				<button type="button" onClick={ deselectAll } className={ styles.controlButton }>{ __( 'Deselect All', 'modula-best-grid-gallery' ) }</button>
			</div>

			<div className={ styles.modulaCheckboxGroupOptions }>
				{ options.map( ( option ) => (
					/* eslint-disable jsx-a11y/label-has-associated-control */
					<label key={ option.value } className={ styles.checkboxOption }>
						<input
							type="checkbox"
							name={ `${ name }[]` }
							value={ option.value }
							checked={ isSelected( option.value ) }
							onChange={ () => toggleCheckbox( option.value ) }
						/>
						<span dangerouslySetInnerHTML={ { __html: option.label } } />
					</label>
				) ) }
			</div>

		</div>
	);
}
