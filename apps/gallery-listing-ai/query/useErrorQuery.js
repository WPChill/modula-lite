import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';
import { useCallback } from '@wordpress/element';

export const useErrorQuery = () => {
	const errors = useQuery({
		queryKey: ['errors'],
		queryFn: async () => {
			const data = await apiFetch({
				path: `/modula-ai-image-descriptor/v1/errors`,
				method: 'GET',
			});
			return data;
		},
	});

	return errors;
};

export const useClearErrorsMutation = () => {
	const queryClient = useQueryClient();
	const mutationFn = useCallback(() => {
		return apiFetch({
			path: `/modula-ai-image-descriptor/v1/clear-errors`,
			method: 'GET',
		});
	}, []);

	const errorsMutation = useMutation({
		mutationFn,
		onSuccess: () => {
			queryClient.invalidateQueries({
				refetchType: 'all',
				queryKey: ['errors'],
			});
		},
	});

	return errorsMutation;
};
