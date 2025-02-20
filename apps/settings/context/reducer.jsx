export const actionTypes = {
	UPDATE_SETTINGS: 'UPDATE_SETTINGS',
	TOGGLE_ADVANCED_REGISTRATION: 'TOGGLE_ADVANCED_REGISTRATION',
	SET_LOGGED_IN: 'SET_LOGGED_IN',
};

export const reducer = (state, action) => {
	switch (action.type) {
		case actionTypes.UPDATE_SETTINGS:
			return {
				...state,
				settings: action.payload,
			};
		case actionTypes.TOGGLE_ADVANCED_REGISTRATION:
			return {
				...state,
				isAdvancedRegistration: action.payload,
			};
		case actionTypes.SET_LOGGED_IN:
			return {
				...state,
				isLoggedIn: action.payload,
			};
		default:
			return state;
	}
};
