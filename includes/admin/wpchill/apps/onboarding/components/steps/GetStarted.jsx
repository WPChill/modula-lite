/* eslint-disable no-undef */
import { useWpchillState } from '../../state/use-wpchill-state';
import { setStep } from '../../state/actions';
import { Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './GetStarted.scss';

export function GetStarted() {
	const { state, dispatch } = useWpchillState();

	const getStarted = () => {
		dispatch( setStep( state.step + 1 ) );
	};

	return (
		<div className="wpchill-getstarted">
			<h1>{ wpchillOnboarding.welcome }</h1>
			<p>{ wpchillOnboarding.welcomeMessage }</p>
			<div className="wpchill-getstarted-button">
				<Button
					variant="primary"
					onClick={ getStarted }
				>
					{ __( 'Get Started →', 'wpchill' ) }
				</Button>
			</div>
		</div>
	);
}
