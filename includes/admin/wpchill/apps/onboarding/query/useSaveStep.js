import { useMutation } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

const saveStep = async ( { key, data } ) => {
	const response = await apiFetch( {
		path: `/wpchill/v1/onboarding/saveStep`,
		method: 'POST',
		data: { key, data },
	} );
	return response;
};

export const useSaveStep = () => {
	return useMutation( {
		mutationFn: saveStep,
	} );
};
