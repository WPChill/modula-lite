export const initialState = ( id ) => {
	const defaultVal = {
		totalImages: 0,
		imagesWithAlt: 0,
		imagesWithoutAlt: 0,
		imagesWithImageSeo: 0,
		imagesWithoutAltIds: [],
		allImageIds: [],
		status: 'running',
		timestamp: new Date().toLocaleDateString(),
		modulaAiSettings: '',
		modulaAiApp: '',
		isStarted: false,
		id,
	};

	if ( typeof id === 'undefined' ) {
		return defaultVal;
	}

	const windowVariableName = `modulaAiGalleryListing${ id }`;
	const windowVariableValue = window[ windowVariableName ];

	if ( ! windowVariableValue ) {
		return defaultVal;
	}

	if ( windowVariableValue.timestamp ) {
		windowVariableValue.timestamp = new Date(
			windowVariableValue.timestamp * 1000,
		).toLocaleDateString();
	}

	return { ...windowVariableValue, isStarted: false, id };
};
