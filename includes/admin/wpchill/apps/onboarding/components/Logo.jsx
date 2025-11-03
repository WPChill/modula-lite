/* eslint-disable no-undef */
export function Logo() {
	if ( 'undefined' === typeof wpchillOnboarding || 'undefined' === typeof wpchillOnboarding.logo ) {
		return;
	}
	return (
		<div className="wpchill-onboarding-logo">
			<img
				className="wpchill-onboarding-logo-img"
				src={ wpchillOnboarding.logo }
				alt="logo"
			/>
		</div>
	);
}
