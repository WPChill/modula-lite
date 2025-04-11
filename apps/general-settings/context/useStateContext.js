import { useContext } from '@wordpress/element';
import { SettingsContext } from './settings-context';

const useStateContext = () => {
	const context = useContext( SettingsContext );

	if ( context === undefined ) {
		throw new Error(
			'useStateContext must be used within a SettingsProvider',
		);
	}

	return context;
};

export default useStateContext;
