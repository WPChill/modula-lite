import { useQueryClient } from '@tanstack/react-query';

export const useAjaxCall = () => {
	const queryClient = useQueryClient();

	const appendFormData = ( formData, key, value ) => {
		if ( Array.isArray( value ) && typeof value[ 0 ] === 'object' ) {
			value.forEach( ( obj, index ) => {
				Object.entries( obj ).forEach( ( [ propKey, propValue ] ) => {
					formData.append( `${ key }[${ index }][${ propKey }]`, propValue );
				} );
			} );
		} else {
			formData.append( key, value );
		}
	};

	const doAjaxCall = async ( data = {}, invalidate = false ) => {
		const formData = new FormData();
		Object.entries( data ).forEach( ( [ key, value ] ) => {
			appendFormData( formData, key, value );
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
					queryKey: [ 'settings-tabs-query' ],
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
