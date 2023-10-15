import apiFetch from '@wordpress/api-fetch';
export const fetcher = (url) => apiFetch({ path: url });
