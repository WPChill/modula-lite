import { useWpchillState } from '../state/use-wpchill-state';
import { GetStarted } from './steps/GetStarted.jsx';
import { AboutYou } from './steps/AboutYou.jsx';
import { Features } from './steps/Features.jsx';
import { Recommended } from './steps/Recommended.jsx';
import { License } from './steps/License.jsx';
import { ThankYou } from './steps/ThankYou.jsx';

const stepsMap = {
	0: GetStarted,
	1: AboutYou,
	2: Features,
	3: Recommended,
	4: License,
	5: ThankYou,
};

export function Steps() {
	const { state } = useWpchillState();
	const StepComponent = stepsMap[ state.step ] || GetStarted;

	return <StepComponent />;
}
