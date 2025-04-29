export const initialState = ( activeTab ) => ( {
	api_key: '',
	isAdvancedRegistration: false,
	isLoggedIn: false,
	activeTab: activeTab || false,
	options: {},
} );
