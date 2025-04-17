import useStateContext from './context/useStateContext';
import { Button } from '@wordpress/components';
import { useSettingsMutation } from './query/useSettingsMutation';
import { __ } from '@wordpress/i18n';
import { setOptions } from './context/actions';
import { useState, useEffect } from '@wordpress/element';

export default function SaveButton() {
	const { state, dispatch } = useStateContext();
	const settingsMutation = useSettingsMutation();
	const [ showNotice, setShowNotice ] = useState( false );

	const isEmpty = Object.keys( state.options || {} ).length === 0;

	const handleClick = () => {
		settingsMutation.mutate( state.options, {
			onSuccess: () => {
				// Reset updated but not saved settings.
				dispatch( setOptions( {} ) );
				setShowNotice( true );
			},
		} );
	};

	useEffect( () => {
		if ( showNotice ) {
			const timer = setTimeout( () => setShowNotice( false ), 3000 );
			return () => clearTimeout( timer );
		}
	}, [ showNotice ] );

	return (
		<div className="modula_save_settings_wrap">
			<Button
				className="modula_save_settings_button"
				onClick={ handleClick }
				disabled={ settingsMutation.isLoading || isEmpty }
				variant="primary"
			>
				{ settingsMutation.isLoading
					? __( 'Saving…', 'modula-best-grid-gallery' )
					: __( 'Save Changes', 'modula-best-grid-gallery' )
				}
			</Button>

			{ showNotice && (
				<div className="modula_save_notice slide-in">
					{ __( 'Settings saved successfully!', 'modula-best-grid-gallery' ) }
				</div>
			) }
		</div>
	);
}
