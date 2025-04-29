import { createRoot } from '@wordpress/element';
import LicenseBlock from './LicenseBlock';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';
import { LicenseProvider } from './context/license-context';
import './index.scss';

document.addEventListener( 'DOMContentLoaded', () => {
	const settings = document.getElementById( 'modula-license-app' );

	if ( ! settings ) {
		return;
	}
	const root = createRoot( settings );

	root.render(
		<QueryClientProvider client={ queryClient }>
			<LicenseProvider>
				<LicenseBlock />
			</LicenseProvider>
		</QueryClientProvider>,
	);
} );
