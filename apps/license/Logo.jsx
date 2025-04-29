/* eslint-disable no-undef */
export default function Logo() {
	const logoUrl = 'undefined' !== typeof modulaData.url ? `${ modulaData.url }assets/images/license-logo.png` : '';
	const footUrl = 'undefined' !== typeof modulaData.url ? `${ modulaData.url }assets/images/license-logo-footer.png` : '';
	return (
		<div className="modula_license_logo_container" style={ { backgroundImage: `url(${ footUrl })` } }
		>
			<img src={ logoUrl } alt="modula logo" className="modula_license_logo" />
		</div>
	);
}
