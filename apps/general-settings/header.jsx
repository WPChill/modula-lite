export default function Header() {
	// eslint-disable-next-line no-undef
	const logoUrl = 'undefined' !== typeof modulaUrl ? `${ modulaUrl }assets/images/logo-dark.webp` : '';
	return (
		<>
			<div className="modula-page-header">
				<div className="modula-header-logo">
					<img src={ logoUrl } alt="modula logo" className="modula-logo" />
				</div>
			</div>
		</>
	);
}
