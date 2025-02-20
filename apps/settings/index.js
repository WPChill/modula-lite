import { createRoot } from '@wordpress/element';
import AiSettings from './ai-settings';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';
import { SettingsProvider } from './context/settings-context';
import './index.css';

document.addEventListener('DOMContentLoaded', () => {
	const settings = document.getElementById('modula-ai-settings');

	if (!settings) {
		return;
	}
	const root = createRoot(settings);

	root.render(
		<QueryClientProvider client={queryClient}>
			<SettingsProvider>
				<AiSettings />
			</SettingsProvider>
		</QueryClientProvider>
	);
});
