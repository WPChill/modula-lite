import { useWpchillState } from './state/use-wpchill-state';
import { useNotificationQuery } from './query/useNotificationQuery';
import { useEffect } from '@wordpress/element';
import { setVisibleNotifications } from './state/actions';
import { ProgressBar } from './components/ProgressBar.jsx';
import { Steps } from './components/Steps.jsx';
import { Logo } from './components/Logo.jsx';

export function Onboarding() {
	return (
		<>
			<div className="wpchill-onboarding-wrapper">
				<ProgressBar />
				<Steps />
			</div>
		</>
	);
}
