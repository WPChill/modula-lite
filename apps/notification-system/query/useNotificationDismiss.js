import { useMutation } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

const dismissNotice = async ( id ) => {
	const response = await apiFetch( {
		path: '/modula-api/v1/clear-notification/' + id,
		method: 'GET',
	} );
	return response;
};

export const useNotificationDismiss = () => {

	return useMutation( {
		mutationFn: dismissNotice,
	} );
};
