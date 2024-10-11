import apiFetch from '@wordpress/api-fetch';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
export const useNotificationQuery = () => {
	return useQuery({
		queryKey: ['notifications'],
		queryFn: async () => {
			const data = await apiFetch({
				path: `/modula-api/v1/notifications`,
				method: 'GET',
			});
			return data;
		},
	});
};