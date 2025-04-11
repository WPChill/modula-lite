import { createRoot } from '@wordpress/element';
import SettingsPage from './settingsPage';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';
import { SettingsProvider } from './context/settings-context';
import './index.scss';

document.addEventListener( 'DOMContentLoaded', () => {
	const settings = document.getElementById( 'modula-settings-app' );

	if ( ! settings ) {
		return;
	}
	const root = createRoot( settings );

	root.render(
		<QueryClientProvider client={ queryClient }>
			<SettingsProvider>
				<SettingsPage />
			</SettingsProvider>
		</QueryClientProvider>,
	);
} );
