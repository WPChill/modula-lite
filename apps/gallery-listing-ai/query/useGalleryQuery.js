import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useGalleryQuery = ( id, isStarted ) => {
	const gallery = useQuery( {
		queryKey: [ 'gallery-status', id ],
		queryFn: async () => {
			const data = await apiFetch( {
				path: `/modula-ai-image-descriptor/v1/gallery-status/${ id }`,
				method: 'GET',
			} );
			return data;
		},
		enabled: isStarted,
	} );

	return gallery;
};
