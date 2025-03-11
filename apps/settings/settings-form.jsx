import ClaimCredits from './settings-form/claim-credits';
import ButtonAction from './settings-form/button-action';
import { __experimentalDivider as Divider } from '@wordpress/components';

export default function SettingsForm() {
	return (
		<>
			<ClaimCredits />
			<Divider margin={8} />
			<ButtonAction />
		</>
	);
}
