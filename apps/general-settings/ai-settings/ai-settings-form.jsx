import ClaimCredits from './settings-form/claim-credits';
import ButtonAction from './settings-form/button-action';

export default function AiSettingsForm() {
	return (
		<>
			<div className="modula_field_wrapper"><ClaimCredits /></div>
			<div className="modula_field_wrapper"><ButtonAction /></div>
		</>
	);
}
