import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useSettingsQuery = () => {
	const settings = useQuery( {
		queryKey: [ 'ai-settings-query' ],
		retry: 1,
		queryFn: async () => {
			const data = await apiFetch( {
				path: `/modula-ai-image-descriptor/v1/ai-settings`,
				method: 'GET',
			} );

			return data;
		},
	} );

	return settings;
};
