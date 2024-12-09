import { createRoot } from '@wordpress/element';
import { Optimizer } from './optimizer';
import './index.scss';
import { OptimizerProvider } from './context/optimizer-context';
import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from './query/client';

document.addEventListener('DOMContentLoaded', () => {
	const optimizerApps = document.querySelectorAll('.mi-gallery-output');

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

	const galleryEdit = document.getElementById('modula-imageseo-metabox');
	if (galleryEdit) {
		const galleryRoot = createRoot(galleryEdit);
		const postId = galleryEdit.getAttribute('data-post-id');
		galleryRoot.render(
			<QueryClientProvider client={queryClient}>
				<OptimizerProvider postId={postId}>
					<Optimizer />
				</OptimizerProvider>
			</QueryClientProvider>
		);
	}
});
