import styles from './toggleField.module.scss';

export default function ToggleField( { fieldState, field, handleChange, className, disabled } ) {
	return (
		<>
			<div className={ `${ styles.modulaToggle } ${ className || '' } ${ disabled ? styles.modulaToggleDisabled : '' }` }>
				<label className={ styles.modulaToggleLabel } htmlFor={ field.name }>{ field.label }</label>
				<input
					id={ field.name }
					className={ styles.modulaToggleInput }
					type="checkbox"
					name={ `modula-settings[${ field.name }]` }
					value="1"
					checked={ fieldState.state.value }
					onChange={ ( e ) => handleChange( e.target.checked ) }
					disabled={ disabled ? 'disabled' : '' }
				/>
				<div className={ styles.modulaToggleItems }>
					<span className={ styles.modulaToggleTrack }></span>
					<span className={ styles.modulaToggleThumb }></span>
					<svg
						className={ styles.modulaToggleOff }
						width="6"
						height="6"
						aria-hidden="true"
						role="img"
						focusable="false"
						viewBox="0 0 6 6"
					>
						<path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
					</svg>
					<svg
						className={ styles.modulaToggleOn }
						width="2"
						height="6"
						aria-hidden="true"
						role="img"
						focusable="false"
						viewBox="0 0 2 6"
					>
						<path d="M0 0h2v6H0z"></path>
					</svg>
				</div>
			</div>
			{ field.description && (
				<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: field.description } } />
			) }
		</>
	);
}
