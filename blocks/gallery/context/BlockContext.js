import { createContext, useReducer, useMemo } from '@wordpress/element';
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

	const value = useMemo(() => {
		return {
			attributes,
			setAttributes,
		};
	}, [setAttributes, attributes]);

	return (
		<BlockContext.Provider value={value}>{children}</BlockContext.Provider>
	);
};

export default BlockContext;
