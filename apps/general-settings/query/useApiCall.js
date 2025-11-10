import apiFetch from '@wordpress/api-fetch';
import { useQueryClient } from '@tanstack/react-query';

export const useApiCall = () => {
	const queryClient = useQueryClient();

	const doApiCall = async ( path, method, data = false ) => {
		try {
			const response = await apiFetch( {
				path,
				method,
				data: { ...data },
			} );

			await queryClient.invalidateQueries( {
				queryKey: [ 'settings-tabs-query' ],
			} );

			return response;
		} catch ( error ) {
			console.error( 'Error on api call:', error );
			throw error;
		}
	};

	return doApiCall;
};
