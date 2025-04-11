import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useTabsQuery = () => {
	const settings = useQuery( {
		queryKey: [ 'tabs-query' ],
		retry: 1,
		queryFn: async () => {
			const data = await apiFetch( {
				path: `/modula-best-grid-gallery/v1/general-settings-tabs`,
				method: 'GET',
			} );

			return data;
		},
	} );

	return settings;
};
