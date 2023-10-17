import { SelectControl, Spinner } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import useSWR from 'swr';
import { fetcher } from '../utils/fetcher';
import { __ } from '@wordpress/i18n';
import useBlockContext from '../hooks/useBlockContext';

export const GallerySelector = () => {
	const { attributes, setAttributes } = useBlockContext();
	const { galleryId } = attributes;

	// This will fetch data from the API
	const { data, error, isLoading } = useSWR('/wp/v2/modula-gallery', fetcher);

	// Compute options here
	const options = useMemo(() => {
		if (isLoading) {
			return [
				{
					value: -1,
					label: __('Fetching Galleries', 'modula-best-grid-gallery'),
				},
			];
		}

		if (error) {
			return [
				{
					value: -1,
					label: __('Error', 'modula-best-grid-gallery'),
				},
			];
		}

		if (!data) {
			return [
				{
					value: -1,
					label: __('No galleries found', 'modula-best-grid-gallery'),
				},
			];
		}

		// return the options - this will be an array of objects with label being the post title and value being the post id
		return data.map((post) => {
			return {
				value: post.id,
				label: post.title.rendered,
			};
		});
	}, [data, error, isLoading]);

	const onChangeCb = (val) => {
		setAttributes({ galleryId: Number(val) });
	};

	console.log(data);

	// You can even consider using conditional rendering
	if (isLoading) {
		return <Spinner />;
	}

	if (error) {
		return <>{__('Error!', 'modula-best-grid-gallery')}</>;
	}

	if (!data) {
		return <>{__('No Galleries found', 'modula-best-grid-gallery')}</>;
	}

	return (
		<SelectControl
			label={__('Choose a gallery', 'modula-best-grid-gallery')}
			value={galleryId}
			onChange={onChangeCb}
			options={options}
		/>
	);
};
