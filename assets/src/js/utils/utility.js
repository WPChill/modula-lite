import { getImagesMeta, getSettings } from "./network";

export const generateSelectOptions = (id, galleries) => {
	const options = galleries.map((page, i) => (
		{ label: page.title.rendered ? escapeHtml(page.title.rendered) : '(no title)', value: page.id }
	));
	if (id === 0) {
		options.unshift({ label: 'Select Gallery...', value: '-1' });
	}
	return options;
};

export const galleryIdUpdated = async (val, setAttributes) => {
	const images = await getImagesMeta(val);
	const { settings, jsConfig } = await getSettings(val, setAttributes);
	setAttributes({
		id: parseInt(val, 10),
		images: images,
		settings: settings.modulaSettings,
		jsConfig: jsConfig,
	})
}

// export const syncSettings = async (val, setAttributes) => {
// 	const images = await getImagesMeta(val);
// 	const { settings, jsConfig } = await getSettings(val, setAttributes);
// 	setAttributes({
// 		images: images,
// 		settings: settings.modulaSettings,
// 	})
// }

export const escapeHtml = text => {
	return text
		.replace("&#8217;", "'")
		.replace("&#8220;", '"')
		.replace("&#8216;", "'");
}
