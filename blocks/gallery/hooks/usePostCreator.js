import { useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { __ } from '@wordpress/i18n';

export const usePostCreator = (postType = 'modula-gallery') => {
	const [loading, setLoading] = useState(false);
	const [error, setError] = useState(null);
	const [data, setData] = useState(null);

	const createPost = async (postData = {}) => {
		const newPost = {
			title: __('New Gallery', 'modula-best-grid-gallery'),
			content: '',
			status: 'publish',
			...postData,
		};

		setLoading(true);
		try {
			const response = await apiFetch({
				path: `/wp/v2/${postType}`,
				method: 'POST',
				data: newPost,
			});
			setData(response);
			setLoading(false);
			return response;
		} catch (err) {
			setError(err);
		} finally {
			setLoading(false);
		}
	};

	return { loading, error, data, createPost };
};
