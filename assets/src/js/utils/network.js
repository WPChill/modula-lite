import apiFetch from '@wordpress/api-fetch';
import { escapeHtml } from './utility';

export const getImagesMeta = async (id) => {
	try {
		const response = await apiFetch({ path: `/modula/v1/gallery-images/${id}` });
		return response.images;
	} catch (error) {
		return `Error: ${error}`;
	}
};

export const getJsConfig = async (settings) => {
	try {
		const response = await apiFetch({
			path: `/modula/v1/gallery-js-config`,
			method: 'POST',
			data: {
				settings: settings.modulaSettings
			},
		});
		return response;
	} catch (error) {
		return `Error: ${error}`;
	}
};

export const getGalleryCptData = async (id, setAttributes) => {
	try {
		const response = await apiFetch({ path: `/wp/v2/modula-gallery/${id}` });
		setAttributes({ currentGallery: response });
		setAttributes({
			currentSelectize: [
				{
					value: id,
					label:
						'' === response.title.rendered
							? `Unnamed`
							: escapeHtml(response.title.rendered),
				},
			],
		});

		return response;
	} catch (error) {
		return `Error: ${error}`;
	}
};

export const getSettings = async (id, setAttributes) => {
	const settings = await getGalleryCptData(id, setAttributes);
	const jsConfig = await getJsConfig(settings);

	return {
		settings: settings,
		jsConfig: jsConfig.js_config,
	};
};
