export default function reducer( state, action ) {
	switch ( action.type ) {
		case 'SET_STEP':
			return { ...state, step: action.payload };
		case 'SET_STEPS_DATA':
			return { ...state, stepsData: action.payload };
		default:
			return state;
	}
}
