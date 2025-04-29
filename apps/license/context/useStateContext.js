import { useContext } from '@wordpress/element';
import { LicenseContext } from './license-context';

const useStateContext = () => {
	const context = useContext( LicenseContext );

	if ( context === undefined ) {
		throw new Error(
			'useStateContext must be used within a SettingsProvider',
		);
	}

	return context;
};

export default useStateContext;
