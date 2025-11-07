/* eslint-disable no-undef */
import { __ } from '@wordpress/i18n';
import { GoBackButton } from '../GoBackButton.jsx';
import { InstallContinueButton } from '../InstallContinueButton.jsx';
import './ThankYou.scss';

export function ThankYou() {
	// Values from PHP via wp_localize_script
	const title =
		wpchillOnboarding?.thankYou ||
		__( 'Congratulations!', 'wpchill' );
	const subtitle =
		wpchillOnboarding?.thankYouMessage ||
		__( "Need Help? Here's what to do next.", 'wpchill' );
	const links = wpchillOnboarding?.thankYouLinks || [];

	return (
		<div className="wpchill-thankyou">
			<div className="wpchill-thankyou-body">
				<h2 className="wpchill-thankyou-title">{ title }</h2>
				<p className="wpchill-thankyou-subtitle">{ subtitle }</p>

				<div className="wpchill-thankyou-list">
					{ links.length > 0 ? (
						links.map( ( item, index ) => (
							<a
								key={ index }
								className="wpchill-thankyou-link"
								href={ item.link }
								target="_blank"
								rel="noopener noreferrer"
							>
								<span
									className={ `dashicons ${
										item.icon || 'dashicons-admin-links'
									} wpchill-thankyou-icon` }
								></span>
								<span className="wpchill-thankyou-text">{ item.text }</span>
							</a>
						) )
					) : (
						<p>{ __( 'No help links found.', 'wpchill' ) }</p>
					) }
				</div>
			</div>

			<div className="wpchill-thankyou-footer">
				<GoBackButton />
				<InstallContinueButton />
			</div>
		</div>
	);
}
