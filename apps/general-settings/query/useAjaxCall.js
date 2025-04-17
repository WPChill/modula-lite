import { useQueryClient } from '@tanstack/react-query';

export const useAjaxCall = () => {
	const queryClient = useQueryClient();

	const doAjaxCall = async ( action, data = {} ) => {
		const formData = new FormData();
		formData.append( 'action', action );

		Object.entries( data ).forEach( ( [ key, value ] ) => {
			formData.append( key, value );
		} );

		try {
			const response = await fetch( window.ajaxurl, {
				method: 'POST',
				credentials: 'same-origin',
				body: formData,
			} );

			const result = await response.json();

			await queryClient.invalidateQueries( {
				queryKey: [ 'settings-tabs-query' ],
			} );

			return result;
		} catch ( error ) {
			console.error( 'AJAX call failed:', error );
			throw error;
		}
	};

	return doAjaxCall;
};
