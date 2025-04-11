import Header from './header';
import Navigation from './navigation';
import Content from './Content';

import { __ } from '@wordpress/i18n';

export default function SettingsPage() {
	return (
		<>
			<Header />
			<Navigation />
			<Content />
		</>
	);
}
