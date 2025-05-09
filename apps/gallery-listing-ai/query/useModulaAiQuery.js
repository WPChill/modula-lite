import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useModulaAiQuery = () => {
	const aiSettings = useQuery({
		queryKey: ['ai-setting'],
		retry: 1,
		queryFn: async () => {
			const data = await apiFetch({
				path: `/modula-best-grid-gallery/v1/ai-settings`,
				method: 'GET',
			});
			return data;
		},
	});

	return aiSettings;
};
