import {
	createContext,
	useReducer,
	useMemo,
	useCallback,
} from '@wordpress/element';
import { reducer } from './reducer';
import { initialState } from './state';

const BlockContext = createContext();

export const BlockProvider = ({
	children,
	initialValues,
	attributes,
	setAttributes,
}) => {
	const mergedInitialState = { ...initialState, ...initialValues };
	const [state, dispatch] = useReducer(reducer, mergedInitialState);

	const incrementStep = useCallback(() => {
		dispatch({ type: 'INCREMENT_STEP' });
	}, []);

	const decrementStep = useCallback(() => {
		dispatch({ type: 'DECREMENT_STEP' });
	}, []);

	const goToStep = useCallback((step) => {
		dispatch({ type: 'GO_TO_STEP', payload: Number(step) });
	}, []);

	const value = useMemo(() => {
		return {
			// Wp core stuff
			attributes,
			setAttributes,
			// State management
			incrementStep,
			decrementStep,
			goToStep,
			// Exposed state
			step: state.step,
		};
	}, [
		attributes,
		setAttributes,
		incrementStep,
		decrementStep,
		goToStep,
		state.step,
	]);

	return (
		<BlockContext.Provider value={value}>{children}</BlockContext.Provider>
	);
};

export default BlockContext;
