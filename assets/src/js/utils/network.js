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

// @todo Make this async/await and return the settings rather than setting them here. The settings part has already been done. Just need to get the jsConfig via a custom REST API endpoint. Need to pass in the settings object though as part of the request, so need to do that first.
export const getSettings = async (id, setAttributes) => {
	const settings = await getGalleryCptData(id, setAttributes);
	const jsConfig = await getJsConfig(settings);

	return {
		settings: settings,
		jsConfig: jsConfig.js_config,
	};

	// jQuery.ajax({
	// 	type: 'POST',
	// 	data: {
	// 		action: 'modula_get_jsconfig',
	// 		nonce: modulaVars.nonce,
	// 		settings: settings.modulaSettings,
	// 	},
	// 	url: modulaVars.ajaxURL,
	// 	success: (result) => {
	// 		setAttributes({
	// 			settings: settings.modulaSettings,
	// 			jsConfig: result,
	// 		});
	// 	},
	// });

	// fetch(`${modulaVars.restURL}wp/v2/modula-gallery/${id}`)
	// 	.then((res) => res.json())
	// 	.then((result) => {
	// 		let settings = result;
	// 		jQuery.ajax({
	// 			type: 'POST',
	// 			data: {
	// 				action: 'modula_get_jsconfig',
	// 				nonce: modulaVars.nonce,
	// 				settings: settings.modulaSettings,
	// 			},
	// 			url: modulaVars.ajaxURL,
	// 			success: (result) => {
	// 				setAttributes({
	// 					settings: settings.modulaSettings,
	// 					jsConfig: result,
	// 				});
	// 			},
	// 		});
	// 	});
};
