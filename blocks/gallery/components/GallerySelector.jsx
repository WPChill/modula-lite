import { SelectControl } from '@wordpress/components';
import { useMemo } from '@wordpress/element';
import useSWR from 'swr';
import { fetcher } from '../utils/fetcher';
import { __ } from '@wordpress/i18n';

export const GallerySelector = () => {
	// Remember to import and use the custom hook useBlockContext() to get the attributes and setter
	// const { ... } = ...();

	// This will fetch data from the API
	const { data, error, isLoading } = useSWR('/wp/v2/modula-gallery', fetcher);

	// Compute options here
	const options = useMemo(
		() => {
			if (isLoading) {
				// return some loading state or just the default
			}

			if (error) {
				// return some error state or just the default
			}

			if (!data) {
				// return some default state with explanation that there's no gallery
			}

			// return the options - this will be an array of objects with label being the post title and value being the post id
			return [];
		},
		[
			//remember to fill in the dependencies here
		]
	);

	// consider moving logic from render to component
	const onChangeCb = () => {
		// also you might consider using useCallback here
	};

	// You can even consider using conditional rendering
	// if (isLoading) {
	// 	return <Spinner />;
	// }

	// if (error){
	//	return <>Some error state</>;
	// }

	return (
		<SelectControl
			label={__('Gallery', 'modula-best-grid-gallery')}
			value={undefined}
			onChange={undefined}
			options={options}
		/>
	);
};
