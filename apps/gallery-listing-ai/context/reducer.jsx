export const actionTypes = {
	UPDATE_TOTAL_IMAGES: 'UPDATE_TOTAL_IMAGES',
	UPDATE_IMAGES_WITH_ALT: 'UPDATE_IMAGES_WITH_ALT',
	UPDATE_IMAGES_WITHOUT_ALT: 'UPDATE_IMAGES_WITHOUT_ALT',
	UPDATE_IMAGES_WITHOUT_ALT_IDS: 'UPDATE_IMAGES_WITHOUT_ALT_IDS',
	UPDATE_ALL_IMAGE_IDS: 'UPDATE_ALL_IMAGE_IDS',
	UPDATE_STATUS: 'UPDATE_STATUS',
	SET_STARTED: 'SET_STARTED',
};

export const reducer = ( state, action ) => {
	switch ( action.type ) {
		case actionTypes.UPDATE_TOTAL_IMAGES:
			return {
				...state,
				totalImages: action.payload,
			};
		case actionTypes.UPDATE_IMAGES_WITH_ALT:
			return {
				...state,
				imagesWithAlt: action.payload,
			};
		case actionTypes.UPDATE_IMAGES_WITHOUT_ALT:
			return {
				...state,
				imagesWithoutAlt: action.payload,
			};
		case actionTypes.UPDATE_IMAGES_WITHOUT_ALT_IDS:
			return {
				...state,
				imagesWithoutAltIds: action.payload,
			};
		case actionTypes.UPDATE_ALL_IMAGE_IDS:
			return {
				...state,
				allImageIds: action.payload,
			};
		case actionTypes.UPDATE_STATUS:
			return {
				...state,
				status: action.payload,
			};
		case actionTypes.SET_STARTED:
			return {
				...state,
				isStarted: action.payload,
			};
		default:
			return state;
	}
};
