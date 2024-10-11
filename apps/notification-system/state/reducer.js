export default function reducer( state, action ) {
	switch ( action.type ) {
		case 'SET_CLOSE_BUBBLE':
			return { ...state, closedBubble: action.payload };
		default:
			return state;
	}
}
