export const actionTypes = {
	SET_LICENSE_KEY: 'SET_LICENSE_KEY',
	SET_ALT_SERVER: 'SET_ALT_SERVER',
	SET_STATUS: 'SET_STATUS',
	SET_MESSAGE: 'SET_MESSAGE',
};

export const reducer = ( state, action ) => {
	switch ( action.type ) {
		case actionTypes.SET_LICENSE_KEY:
			return {
				...state,
				licenseKey: action.payload,
			};
		case actionTypes.SET_ALT_SERVER:
			return {
				...state,
				altServer: action.payload,
			};
		case actionTypes.SET_STATUS:
			return {
				...state,
				status: action.payload,
			};
		case actionTypes.SET_MESSAGE:
			return {
				...state,
				message: action.payload,
			};
		default:
			return state;
	}
};
