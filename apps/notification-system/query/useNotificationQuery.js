import apiFetch from '@wordpress/api-fetch';
import { useQuery } from '@tanstack/react-query';
export const useNotificationQuery = () => {
	return useQuery({
		queryKey: ['notifications'],
		queryFn: async () => {
			const data = await apiFetch({
				path: `/modula/v1/notifications`,
				method: 'GET',
			});
			return data;
		},
		refetchInterval: ( query ) => query?.state?.fetchFailureCount < 5 ? 5000 : false,
	});
};