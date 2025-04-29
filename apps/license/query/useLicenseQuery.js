import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useLicenseQuery = () => {
	const settings = useQuery( {
		queryKey: [ 'modula-license-query' ],
		retry: 1,
		queryFn: async () => {
			const data = await apiFetch( {
				path: `/modula-best-grid-gallery/v1/license-data`,
				method: 'GET',
			} );

			return data;
		},
	} );

	return settings;
};
