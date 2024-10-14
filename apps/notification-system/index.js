import './index.scss';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';
import { Notifications } from './notifications';
import { StateProvider } from './state/state';
import { createRoot } from '@wordpress/element';

document.addEventListener('DOMContentLoaded', () => {
	const postsContainer = document.getElementById('wpwrap');
	if (postsContainer) {
		const div = document.createElement('div');
		const wrapper = document.createElement('div');
		wrapper.setAttribute('id', 'modula-notifications-wrapper');
		wrapper.classList.add('modula-best-grid-gallery');
		div.setAttribute('id', 'modula-notifications-root');

		postsContainer.prepend(wrapper);
		wrapper.appendChild(div);
		const root = createRoot(
			document.getElementById('modula-notifications-root')
		);

		root.render(
			<QueryClientProvider client={queryClient}>
				<StateProvider>
					<Notifications />
				</StateProvider>
			</QueryClientProvider>
		);
	}
});
