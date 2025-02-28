import {
	Card,
	CardBody,
	CardHeader,
	__experimentalSpacer as Spacer,
} from '@wordpress/components';
import SettingsForm from './settings-form';
import { __ } from '@wordpress/i18n';

export default function AiSettings() {
	return (
		<>
			<Spacer marginTop={4} marginBottom={4} />
			<Card>
				<CardHeader>
					<h2>{__('Modula AI', 'modula-best-grid-gallery')}</h2>
				</CardHeader>
				<CardBody>
					<SettingsForm />
				</CardBody>
			</Card>
		</>
	);
}
