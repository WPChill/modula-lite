import { useWpchillState } from '../../state/use-wpchill-state';

export function GetStarted() {
	const { state } = useWpchillState();

	return 'GetStarted';
}
