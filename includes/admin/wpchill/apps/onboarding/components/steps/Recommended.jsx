import { useWpchillState } from '../../state/use-wpchill-state';

export function Recommended() {
	const { state } = useWpchillState();

	return 'step3';
}
