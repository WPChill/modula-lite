/* eslint-disable no-undef */
export function Logo() {
	console.log( modulaOnboarding.logo );
	if ( 'undefined' === typeof modulaOnboarding || 'undefined' === typeof modulaOnboarding.logo ) {
		return;
	}
	return (
		<div className="wpchill-onboarding-logo">
			<img
				className="wpchill-onboarding-logo-img"
				src={ modulaOnboarding.logo }
				alt="logo"
			/>
		</div>
	);
}
