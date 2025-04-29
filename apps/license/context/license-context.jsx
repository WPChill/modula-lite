import { createContext, useReducer } from '@wordpress/element';
import { reducer } from './reducer';
import { initialState } from './initial-state';

export const LicenseContext = createContext( initialState );
export const LicenseProvider = ( { children } ) => {
	const [ state, dispatch ] = useReducer( reducer, initialState );

	const contextValue = {
		state,
		dispatch,
	};

	return (
		<LicenseContext.Provider value={ contextValue }>
			{ children }
		</LicenseContext.Provider>
	);
};
