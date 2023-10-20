export const reducer = (state, action) => {
	switch (action.type) {
		case 'INCREMENT_STEP':
			return {
				...state,
				step: state.step + 1,
			};
		case 'DECREMENT_STEP':
			return {
				...state,
				step: state.step > 0 ? state.step - 1 : 0,
			};
		case 'GO_TO_STEP':
			return {
				...state,
				step: action.step,
			};
		default:
			return state;
	}
};
