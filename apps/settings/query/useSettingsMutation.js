import { useMutation, useQueryClient } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';
import { useCallback } from '@wordpress/element';

export const useSettingsMutation = ({ onSuccess } = {}) => {
	const queryClient = useQueryClient();

	const mutationFn = useCallback((vars) => {
		return apiFetch({
			path: `/modula-ai-image-descriptor/v1/ai-settings`,
			method: 'POST',
			data: {
				api_key: vars.api_key,
				language: vars.language,
			},
		});
	}, []);

	const settingsMutation = useMutation({
		mutationFn,
		onSuccess: (data, variables, context) => {
			queryClient.invalidateQueries({
				refetchType: 'all',
				queryKey: ['settings-query'],
			});
			if (onSuccess) {
				onSuccess(data, variables, context);
			}
		},
	});

	return settingsMutation;
};
