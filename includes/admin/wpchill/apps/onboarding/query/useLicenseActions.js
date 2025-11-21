import { useMutation } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

const callLicenseAPI = async ( { licenseKey, url, action, siteUrl, source } ) => {
	return await apiFetch( {
		path: `/wpchill/v1/onboarding/check-license`,
		method: 'POST',
		data: {
			url,
			license_key: licenseKey,
			site_url: siteUrl,
			action,
			source,
		},
	} );
};

export const useLicenseActions = () => {
	return useMutation( {
		mutationFn: callLicenseAPI,
	} );
};
