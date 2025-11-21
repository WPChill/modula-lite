export default function reducer( state, action ) {
	switch ( action.type ) {
		case 'SET_SOURCE':
			return { ...state, source: action.payload };
		case 'SET_STEP':
			return { ...state, step: action.payload };
		case 'SET_MAX_STEP':
			return { ...state, maxStep: action.payload };
		case 'SET_STEPS_DATA':
			return { ...state, stepsData: action.payload };
		default:
			return state;
	}
}
