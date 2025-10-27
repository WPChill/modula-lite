import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';

export const useGetOnboardingRecommended = ( source = 'wpchill' ) => {
	return useQuery( {
		queryKey: [ 'onboardingRecommended', source ],
		queryFn: () => {
			return apiFetch( {
				path: addQueryArgs( '/wpchill/v1/onboarding/recommended', { source } ),
			} );
		},
	} );
};
