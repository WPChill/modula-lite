import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useImageseoQuery = () => {
	const imageseo = useQuery({
		queryKey: ['imageseo-query'],
		retry: 1,
		queryFn: async () => {
			const data = await apiFetch({
				path: `/modula-imageseo/v1/imageseo-query`,
				method: 'GET',
			});
			return data;
		},
	});

	return imageseo;
};
