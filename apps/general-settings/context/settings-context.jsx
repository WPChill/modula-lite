import { createContext, useReducer } from '@wordpress/element';
import { reducer } from './reducer';
import { initialState } from './initial-state';

export const SettingsContext = createContext( initialState );
export const SettingsProvider = ( { children } ) => {
	const [ state, dispatch ] = useReducer( reducer, initialState );

	const contextValue = {
		state,
		dispatch,
	};

	return (
		<SettingsContext.Provider value={ contextValue }>
			{ children }
		</SettingsContext.Provider>
	);
};
