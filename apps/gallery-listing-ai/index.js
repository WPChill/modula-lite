import { createRoot } from '@wordpress/element';
import { Optimizer } from './optimizer';
import './index.scss';
import { OptimizerProvider } from './context/optimizer-context';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';

document.addEventListener('DOMContentLoaded', () => {
	const optimizerApps = document.querySelectorAll('.mai-gallery-output');
	optimizerApps.forEach((rootApp) => {
		const root = createRoot(rootApp);
		const postId = rootApp.getAttribute('data-post-id');
		root.render(
			<QueryClientProvider client={queryClient}>
				<OptimizerProvider postId={postId}>
					<Optimizer />
				</OptimizerProvider>
			</QueryClientProvider>
		);
	});
});
