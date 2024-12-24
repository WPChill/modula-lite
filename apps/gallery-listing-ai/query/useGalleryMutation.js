import { useMutation, useQueryClient } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';
import { useCallback } from '@wordpress/element';
import useStateContext from '../context/useStateContext';

export const useGalleryMutation = () => {
	const { state } = useStateContext();
	const queryClient = useQueryClient();
	const mutationFn = useCallback(
		(vars) => {
			const endpoint =
				vars.action === 'start'
					? 'optimize-gallery'
					: 'stop-optimizing-gallery';

			return apiFetch({
				path: `/modula-imageseo/v1/${endpoint}`,
				method: 'POST',
				data: {
					id: vars.id || state.id,
					action:
						vars?.onlyMissing && vars.onlyMissing
							? 'without'
							: 'all',
				},
			});
		},
		[state.id]
	);

	const galleryMutation = useMutation({
		mutationFn,
		onSuccess: (data, vars) => {
			queryClient.invalidateQueries({
				refetchType: 'all',
				queryKey: ['gallery-status', state.id || vars.id],
			});
		},
	});

	return galleryMutation;
};
