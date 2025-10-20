import { useMutation } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

const saveStep = async ( { source, key, data } ) => {
	const response = await apiFetch( {
		path: `/wpchill/v1/onboarding/save-step`,
		method: 'POST',
		data: { source, key, data },
	} );
	return response;
};

export const useSaveStep = () => {
	return useMutation( {
		mutationFn: saveStep,
	} );
};
