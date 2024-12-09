import { __ } from '@wordpress/i18n';
import { useGalleryMutation } from './query/useGalleryMutation';
import useStateContext from './context/useStateContext';
import { useImageseoQuery } from './query/useImageseoQuery';
import { Button, Spinner } from '@wordpress/components';
import { useCallback } from '@wordpress/element';

export function Actions() {
	const mutation = useGalleryMutation();
	const { isLoading, isError, error } = useImageseoQuery();

	const { state } = useStateContext();

	const optimizeAll = () => {
		mutation.mutate({ action: 'start', id: state.id });
	};

	const optimizeMissing = () => {
		mutation.mutate({ action: 'start', id: state.id, onlyMissing: true });
	};

	const goToImageseo = useCallback(() => {
		window.open(`${state?.imageseoSettings}` || '', '_blank');
	}, [state?.imageseoSettings]);

	if (isLoading) {
		return <Spinner />;
	}

	if (isError && error) {
		return (
			<>
				<small>
					{__(
						'Oops! There was an error connecting to the API. Please make sure you have configured your API key correctly in the Image SEO settings.',
						'modula-imageseo'
					)}
				</small>
				<div className="image-seo-actions">
					<Button variant="secondary" onClick={goToImageseo}>
						{__('Configure Image SEO', 'modula-imageseo')}
					</Button>
				</div>
			</>
		);
	}

	return (
		<div className="image-seo-actions">
			<Button variant="secondary" onClick={optimizeAll}>
				{__('Optimize all', 'modula-imageseo')}
			</Button>
			<Button variant="secondary" onClick={optimizeMissing}>
				{__('Only missings', 'modula-imageseo')}
			</Button>
		</div>
	);
}
