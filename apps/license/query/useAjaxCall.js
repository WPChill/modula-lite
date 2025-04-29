import { useQueryClient } from '@tanstack/react-query';

export const useAjaxCall = () => {
	const queryClient = useQueryClient();

	const doAjaxCall = async ( data = {}, invalidate = false ) => {
		const formData = new FormData();
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

			if ( invalidate ) {
				await queryClient.invalidateQueries( {
					queryKey: [ 'modula-license-query' ],
				} );
			}

			return result;
		} catch ( error ) {
			console.error( 'AJAX call failed:', error );
			throw error;
		}
	};

	return doAjaxCall;
};
