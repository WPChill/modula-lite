import { actionTypes } from './reducer';

export const setActiveTab = ( value ) => ( {
	type: actionTypes.SET_ACTIVE_TAB,
	payload: value,
} );

export const setOptions = ( value ) => ( {
	type: actionTypes.SET_OPTIONS,
	payload: value,
} );

export const toggleAdvancedRegistration = ( value ) => ( {
	type: actionTypes.TOGGLE_ADVANCED_REGISTRATION,
	payload: value,
} );

export const setLoggedIn = ( value ) => ( {
	type: actionTypes.SET_LOGGED_IN,
	payload: value,
} );
