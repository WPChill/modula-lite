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
	const posts = [];

	if (data) {
		data.map((item) => {
			posts.push({
				value: item.id,
				label: item.title.rendered,
			});
		});
	}

	// Compute options here
	const options = useMemo(() => {
		if (isLoading) {
			return <Spinner />;
		}

		if (error) {
			console.log(error);
		}

		if (!data) {
			return (
				<>
					{__(
						'No galleries found, please go ahead and create a new Modula gallery.',
						'modula-best-grid-gallery'
					)}
				</>
			);
		}

		// return the options - this will be an array of objects with label being the post title and value being the post id
		return posts;
	}, data);

	// consider moving logic from render to component
	const onChangeCb = (val) => {
		setAttributes({ galleryId: Number(val) });
	};

	return (
		<SelectControl
			label={__('Gallery', 'modula-best-grid-gallery')}
			value={galleryId}
			onChange={onChangeCb}
			options={options}
		/>
	);
};
