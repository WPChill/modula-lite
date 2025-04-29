import { actionTypes } from './reducer';

export const setLicenseKey = ( value ) => ( {
	type: actionTypes.SET_LICENSE_KEY,
	payload: value,
} );

export const setAltServer = ( value ) => ( {
	type: actionTypes.SET_ALT_SERVER,
	payload: value,
} );

export const setStatus = ( value ) => ( {
	type: actionTypes.SET_STATUS,
	payload: value,
} );

export const setMessage = ( value ) => ( {
	type: actionTypes.SET_MESSAGE,
	payload: value,
} );

