import { useMutation } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

const installPlugins = async ( { plugins } ) => {
	const response = await apiFetch( {
		path: `/wpchill/v1/onboarding/install-plugins`,
		method: 'POST',
		data: { plugins },
	} );
	return response;
};

export const useInstallPlugins = () => {
	return useMutation( {
		mutationFn: installPlugins,
	} );
};
