import './index.scss';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';
import { Onboarding } from './Onboarding';
import { StateProvider } from './state/state';
import { createRoot } from '@wordpress/element';

document.addEventListener( 'DOMContentLoaded', () => {
	const root = createRoot(
		document.getElementById( 'wpchill-onboarding-root' ),
	);
	root.render(
		<QueryClientProvider client={ queryClient }>
			<StateProvider>
				<Onboarding />
			</StateProvider>
		</QueryClientProvider>,
	);
} );
