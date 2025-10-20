import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

export const useGetOnboardingData = ( source = 'wpchill' ) => {
	return useQuery( {
		queryKey: [ 'onboardingData', source ],
		queryFn: () => {
			return apiFetch( {
				path: addQueryArgs( '/wpchill/v1/onboarding/data', { source } ),
			} );
		},
	} );
};
