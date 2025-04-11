import { useMutation, useQueryClient } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';

export const useSettingsMutation = () => {
	const queryClient = useQueryClient();

	const saveSettings = async ( vars ) => {
		return await apiFetch( {
			path: `/modula-best-grid-gallery/v1/general-settings`,
			method: 'POST',
			data: vars,
		} );
	};

	const settingsMutation = useMutation( {
		mutationFn: async ( data ) => {
			const result = await saveSettings( data );
			return result;
		},
		onSuccess: async () => {
			await queryClient.invalidateQueries( {
				queryKey: [ 'settinga-tabs-query' ],
			} );
		},
	},
	);

	return settingsMutation;
};
