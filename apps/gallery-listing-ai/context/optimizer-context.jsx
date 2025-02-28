import { createContext, useReducer } from '@wordpress/element';
import { reducer } from './reducer';
import { initialState } from './initial-state';
import { useGalleryQuery } from '../query/useGalleryQuery';

export const OptimizerContext = createContext(initialState());
export const OptimizerProvider = ({ children, postId }) => {
	const { data, isLoading } = useGalleryQuery(postId);
	const [state, dispatch] = useReducer(reducer, initialState(postId));

	const contextValue = {
		state,
		dispatch,
		data,
		isLoading,
	};

	return (
		<OptimizerContext.Provider value={contextValue}>
			{children}
		</OptimizerContext.Provider>
	);
};
