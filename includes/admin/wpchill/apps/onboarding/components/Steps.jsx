import { useWpchillState } from '../state/use-wpchill-state';
import { GetStarted } from './steps/GetStarted.jsx';
import { AboutYou } from './steps/AboutYou.jsx';
import { Features } from './steps/Features.jsx';
import { Recommended } from './steps/Recommended.jsx';
import { License } from './steps/License.jsx';
import { ThankYou } from './steps/ThankYou.jsx';

const stepsMap = [
	GetStarted, // 0
	AboutYou, // 1
	Features, // 2
	Recommended, // 3
	License, // 4
	ThankYou, // 5
];

export function Steps() {
	const { state } = useWpchillState();
	let finalSteps = [ ...stepsMap ];
	if ( state.stepsData.license_status && state.stepsData.license_status.license && 'valid' === state.stepsData.license_status.license ) {
		console.error( state.stepsData.license_status );
		finalSteps = finalSteps.filter( ( step ) => step !== License );
	}
	const StepComponent = finalSteps[ state.step ] || GetStarted;

	return <StepComponent />;
}
