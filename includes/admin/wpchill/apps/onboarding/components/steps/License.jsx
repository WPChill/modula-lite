import { useState } from 'react';
import { useWpchillState } from '../../state/use-wpchill-state';
import { setStepsData } from '../../state/actions';
import {
	TextControl,
	Button,
	Notice,
	Spinner,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { SaveContinueButton } from '../SaveContinueButton.jsx';
import { GoBackButton } from '../GoBackButton.jsx';
import { useLicenseActions } from '../../query/useLicenseActions';
import './License.scss';

export function License() {
	const { state, dispatch } = useWpchillState();
	const { mutate } = useLicenseActions();

	const stepKey = 'license';

	const [ message, setMessage ] = useState( null );
	const [ messageType, setMessageType ] = useState( 'info' );
	const [ isSuccess, setIsSuccess ] = useState( false );
	const [ loading, setLoading ] = useState( false );

	const handleLicenseInput = ( $key ) => {
		dispatch( setStepsData( { license_key: $key } ) );
	};

	const handleConnect = () => {
		setMessage( null );
		setLoading( true );

		mutate(
			{
				url: 'https://wp-modula.com/wp-json/wpchill-utils/v1/license',
				licenseKey: state.stepsData.license_key,
				siteUrl: window.location.origin,
				action: 'activate',
				source: state.source || 'wpchill',
			},
			{
				onSuccess: ( json ) => {
					const successFlag =
						json?.success === true ||
						json?.results?.success === true;

					setIsSuccess( successFlag );

					setMessage(
						json?.results?.message ||
						json?.message ||
						__( 'License checked.', 'wpchill' ),
					);

					setMessageType( successFlag ? 'success' : 'error' );
					setLoading( false ); // END SPINNER
				},

				onError: () => {
					setMessage( __( 'Something went wrong.', 'wpchill' ) );
					setMessageType( 'error' );
					setLoading( false ); // END SPINNER
				},
			}
		);
	};

	return (
		<div className="wpchill-license">
			<div className="wpchill-license-body">
				<h2 className="wpchill-license-title">
					{ __( 'Activate Your License', 'wpchill' ) }
				</h2>

				<p className="wpchill-license-subtitle">
					{ __( 'Connect your WPChill license to receive updates and support.', 'wpchill' ) }
				</p>

				<div className="wpchill-license-row">
					<div className="wpchill-license-input">
						<TextControl
							label={ __( 'License Key', 'wpchill' ) }
							value={ state.stepsData.license_key || '' }
							onChange={ ( v ) => handleLicenseInput( v ) }
							placeholder="xxxx-xxxx-xxxx-xxxx"
							disabled={ loading || isSuccess }
						/>
					</div>

					<Button
						variant="primary"
						className="wpchill-license-connect-btn"
						onClick={ handleConnect }
						disabled={ loading || ! state.stepsData.license_key || isSuccess }
					>
						{ loading ? <Spinner /> : __( 'Connect', 'wpchill' ) }
					</Button>
				</div>

				{ message && (
					<div style={ { marginTop: '15px' } }>
						<Notice status={ messageType } isDismissible={ false }>
							{ message }
						</Notice>
					</div>
				) }
			</div>

			<div className="wpchill-license-footer">
				<GoBackButton />
				<SaveContinueButton keyName={ stepKey } />
			</div>
		</div>
	);
}
