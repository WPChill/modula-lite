import { useMutation } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

const dismissNotice = async ( data ) => {
	console.error(data);
	const response = await apiFetch( {
		path: '/modula-api/v1/notifications/',
		method: 'DELETE',
		data: data,
	} );
	return response;
};

export const useNotificationDismiss = () => {

	return useMutation( {
		mutationFn: dismissNotice,
	} );
};
