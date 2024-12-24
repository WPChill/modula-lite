import { useQuery } from '@tanstack/react-query';
import apiFetch from '@wordpress/api-fetch';
import { Spinner } from '@wordpress/components';
import useStateContext from './context/useStateContext';

const debugOn = localStorage.getItem('imageseo_debug_log');
export const ErrorLog = () => {
	if (debugOn) {
		return <Debug />;
	}

	return null;
};

const Debug = () => {
	const { state } = useStateContext();
	const { isLoading, data } = useQuery({
		queryKey: ['gallery-debug', state.id],
		queryFn: async () => {
			const dataF = await apiFetch({
				path: `/modula-imageseo/v1/gallery-debug/${state.id}`,
				method: 'GET',
			});
			return dataF;
		},
	});

	if (isLoading) {
		return <Spinner />;
	}

	return (
		<>
			<h4>Debug Info</h4>
			<pre>{JSON.stringify(data, null, 2)}</pre>
		</>
	);
};
