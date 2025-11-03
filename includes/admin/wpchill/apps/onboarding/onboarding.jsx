import { useWpchillState } from './state/use-wpchill-state';
import { useGetOnboardingData } from './query/useGetOnboardingData';
import { setStepsData, setSource } from './state/actions';
import { useEffect } from '@wordpress/element';
import { ProgressBar } from './components/ProgressBar.jsx';
import { Steps } from './components/Steps.jsx';
import { Logo } from './components/Logo.jsx';

export function Onboarding() {
	const { state, dispatch } = useWpchillState();
	const { data, isLoading, error } = useGetOnboardingData( state.source );

	useEffect( () => {
		const slug = window?.wpchillOnboarding?.slug ?? 'wpchill';
		console.log( slug );
		dispatch( setSource( slug ) );
	}, [ dispatch ] );

	useEffect( () => {
		if ( data && ! isLoading && ! error ) {
			dispatch( setStepsData( data ) );
		}
	}, [ data, isLoading, error, dispatch ] );

	return (
		<div className="wpchill-onboarding-wrapper">
			<Logo />
			<div className="wpchill-onboarding-content">
				<ProgressBar />
				<Steps />
			</div>
		</div>
	);
}
