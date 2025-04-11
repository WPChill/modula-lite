import { QueryClientProvider } from '@tanstack/react-query';
import SettingsForm from './settings-form';
import { queryClient } from './query/client';
import { SettingsProvider } from './context/settings-context';
import './index.css';

const AiSettingsApp = () => {
	return (
		<QueryClientProvider client={ queryClient }>
			<SettingsProvider>
				<SettingsForm />
			</SettingsProvider>
		</QueryClientProvider>
	);
};

export default AiSettingsApp;
