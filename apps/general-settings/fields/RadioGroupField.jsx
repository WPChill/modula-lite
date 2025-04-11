
import styles from './radioGroupField.module.scss';

export default function RadioGroupField( { fieldState, field, handleChange, className } ) {
	const { options, name } = field;
	return (
		<div className={ `${ styles.modulaImageRadioGroup } ${ className || '' }` }>
			{ options.map( ( option ) => (
				<div key={ `${ option.value }-${ option.label }` } className={ styles.modulaImageRadioGroupOption }>
					<input
						type="radio"
						id={ option.value }
						name={ name }
						value={ option.value }
						checked={ fieldState.state.value === option.value }
						onChange={ ( e ) => handleChange( e.target.value ) }
						className={ styles.modulaImageRadioGroupInput }
					/>
					<label
						className={ `${ styles.modulaImageRadioGroupLabel } ${
							fieldState.state.value === option.value ? styles.modulaImageRadioGroupLabelChecked : ''
						}` }
						htmlFor={ option.value }
					>
						{ option.image && '' !== option.image && ( <img className={ styles.modulaImageRadioGroupImage } src={ option.image } alt={ option.name } /> ) }
						<p className={ styles.modulaImageRadioGroupText } >{ option.name }</p>
					</label>
				</div>
			) ) }
		</div>
	);
}
