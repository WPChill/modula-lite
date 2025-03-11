import { __ } from '@wordpress/i18n';
import { useGalleryMutation } from './query/useGalleryMutation';
import useStateContext from './context/useStateContext';
import { Button } from '@wordpress/components';
export function Optimizing() {
	const mutation = useGalleryMutation();
	const { state } = useStateContext();

	const stop = () => {
		mutation.mutate({ action: 'stop', id: state.id });
	};

	return (
		<div className="modula-ai-list">
			<p>{__('Optimizing images…', 'modula-best-grid-gallery')}</p>
			<small>
				{__(
					'This may take a while depending on the number of images. Feel free to navigate away from this page. We will notify you when the process is finished.',
					'modula-best-grid-gallery'
				)}
			</small>
			<div className="modula-ai-actions">
				<Button variant="secondary" onClick={stop}>
					{__('Stop', 'modula-best-grid-gallery')}
				</Button>
			</div>
		</div>
	);
}
