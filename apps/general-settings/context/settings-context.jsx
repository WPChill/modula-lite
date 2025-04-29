import { createContext, useReducer } from '@wordpress/element';
import { reducer } from './reducer';
import { initialState } from './initial-state';

export const SettingsContext = createContext( initialState );

export const SettingsProvider = ( { children, activeTab } ) => {
	const [ state, dispatch ] = useReducer(
		reducer,
		initialState,
		(initial) => ( { ...initial, activeTab } )
	);

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
