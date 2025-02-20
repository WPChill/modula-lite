import { __ } from '@wordpress/i18n';
import { useGalleryMutation } from './query/useGalleryMutation';
import useStateContext from './context/useStateContext';
import { useModulaAiQuery } from './query/useModulaAiQuery';
import { Button, Spinner } from '@wordpress/components';
import { useCallback } from '@wordpress/element';

export function Actions() {
	const mutation = useGalleryMutation();
	const { data, isLoading, isError, error } = useModulaAiQuery();

	const { state } = useStateContext();

	const optimizeAll = () => {
		mutation.mutate({ action: 'start', id: state.id });
	};

	const optimizeMissing = () => {
		mutation.mutate({ action: 'start', id: state.id, onlyMissing: true });
	};

	const goToModulaAiSettings = useCallback(() => {
		const url = state?.modulaAiSettings || '';

		const decoded = decodeURIComponent(url)
			.replace(/&#038;/g, '&')
			.replace(/&amp;/g, '&')
			.replace(/#038;/g, '')
			.replace(/\s+/g, '');

		window.open(decoded, '_blank');
	}, [state?.modulaAiSettings]);

	if (isLoading) {
		return <Spinner />;
	}

	if ((isError && error) || !data?.readonly?.valid_key) {
		return (
			<>
				<small>
					{__(
						'Oops! There was an error connecting to the API. Please make sure you have configured your API key correctly in the Modula AI settings.',
						'modula-best-grid-gallery'
					)}
				</small>
				<div className="modula-ai-actions">
					<Button variant="secondary" onClick={goToModulaAiSettings}>
						{__('Configure Modula AI', 'modula-best-grid-gallery')}
					</Button>
				</div>
			</>
		);
	}

	if (0 === state?.imagesWithoutAlt) {
		return (
			<div className="modula-ai-actions">
				<Button variant="secondary" onClick={optimizeAll}>
					{__('Refresh alts', 'modula-best-grid-gallery')}
				</Button>
			</div>
		);
	}

	return (
		<div className="modula-ai-actions">
			<Button variant="secondary" onClick={optimizeAll}>
				{__('Optimize all', 'modula-best-grid-gallery')}
			</Button>
			<Button variant="secondary" onClick={optimizeMissing}>
				{__('Only missings', 'modula-best-grid-gallery')}
			</Button>
		</div>
	);
}
