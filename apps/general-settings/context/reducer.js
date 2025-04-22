export const actionTypes = {
	SET_ACTIVE_TAB: 'SET_ACTIVE_TAB',
	SET_OPTIONS: 'SET_OPTIONS',
	UPDATE_SETTINGS: 'UPDATE_SETTINGS',
	TOGGLE_ADVANCED_REGISTRATION: 'TOGGLE_ADVANCED_REGISTRATION',
	SET_LOGGED_IN: 'SET_LOGGED_IN',
};

export const reducer = ( state, action ) => {
	switch ( action.type ) {
		case actionTypes.SET_ACTIVE_TAB:
			return {
				...state,
				activeTab: action.payload,
			};
		case actionTypes.SET_OPTIONS:
			return {
				...state,
				options: action.payload,
			};
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
