import { useCallback, useState } from '@wordpress/element';
import styles from './ImportCheckboxGroupField.module.scss';
import { __ } from '@wordpress/i18n';
import { useAjaxCall } from '../query/useAjaxCall';
import { Button } from '@wordpress/components';
import useStateContext from '../context/useStateContext';
export default function ImportCheckboxGroupField( { fieldState, field, handleChange, className } ) {
	const { options, name } = field;
	const selectedValues = fieldState.state.value || [];
	const [ loading, setLoading ] = useState( false );
	const { state } = useStateContext();
	const doAjaxCall = useAjaxCall();

	const source = state.options?.gallery_source || 'core';
	const deleteSource = state.options?.gallery_delete_source || 'keep';

	const isSelected = ( value ) => selectedValues.includes( value );

	const toggleCheckbox = ( value ) => {
		if ( isSelected( value ) ) {
			handleChange( selectedValues.filter( ( v ) => v !== value ) );
		} else {
			handleChange( [ ...selectedValues, value ] );
		}
	};

	const handleClick = async () => {
		setLoading( true );

		for ( const id of selectedValues ) {
			const data = {
				action: 'modula_ajax_import_images',
				id,
				nonce: field.nonce || false,
				chunk: 0,
				source,
			};
			const response = await doAjaxCall( data );

			const importData = {
				action: 'modula_importer_' + source + '_gallery_import',
				id,
				nonce: field.nonce,
				clean: deleteSource,
				gallery_title: id,
				attachments:
				response.attachments,
				source,
			};

			await doAjaxCall( importData, true );
		}

		setLoading( false );
	};

	const selectAll = useCallback( () => {
		const allValues = options.map( ( opt ) => opt.value );
		handleChange( allValues );
	}, [ options, handleChange ] );

	const deselectAll = useCallback( () => {
		handleChange( [] );
	}, [ handleChange ] );

	return (
		<div className={ `${ styles.modulaCheckboxGroupWrap } ${ className || '' }` }>
			<div className={ styles.modulaCheckboxGroup } >
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
			<Button
				variant="primary"
				className={ `modula_field_button ${ className || '' }` }
				onClick={ handleClick }
				disabled={ loading }
			>
				{ loading ? __( 'Migrating…', 'modula-best-grid-gallery' ) : __( 'Migrate', 'modula-best-grid-gallery' ) }
			</Button>

		</div>
	);
}
