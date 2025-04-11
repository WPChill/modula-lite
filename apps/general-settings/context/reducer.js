export const actionTypes = {
	SET_ACTIVE_TAB: 'SET_ACTIVE_TAB',
};

export const reducer = (state, action) => {
	switch (action.type) {
		case actionTypes.SET_ACTIVE_TAB:
			return {
				...state,
				activeTab: action.payload,
			};
		default:
			return state;
	}
};
