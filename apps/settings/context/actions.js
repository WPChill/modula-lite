import { actionTypes } from './reducer';

export const toggleAdvancedRegistration = (value) => ({
	type: actionTypes.TOGGLE_ADVANCED_REGISTRATION,
	payload: value,
});

export const setLoggedIn = (value) => ({
	type: actionTypes.SET_LOGGED_IN,
	payload: value,
});
