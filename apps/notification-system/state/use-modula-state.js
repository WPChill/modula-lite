import { createContext, useContext } from '@wordpress/element';
export const StateContext = createContext();

export function useModulaState() {
	const context = useContext( StateContext );
	if ( ! context ) {
		throw new Error( 'useModulaState must be used within a StateProvider' );
	}
	return context;
}
