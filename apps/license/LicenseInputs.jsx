import { Button, TextControl, Spinner } from '@wordpress/components';
import ToggleField from './ToggleField';
import useStateContext from './context/useStateContext';
import { setLicenseKey, setAltServer, setStatus, setMessage } from './context/actions';
import { useLicenseQuery } from './query/useLicenseQuery';
import { useAjaxCall } from './query/useAjaxCall';
import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
export default function Navigation() {
	const { state, dispatch } = useStateContext();
	const { data, isLoading } = useLicenseQuery();
	const [ actionLoading, setActionLoading ] = useState( false );
	const [ actionMessage, setActionMessage ] = useState( false );

	const [ showForgotLicense, setShowForgotLicense ] = useState( false );

	const [ licenseEmail, setLicenseEmail ] = useState( '' );
	const [ forgotLoading, setForgotLoading ] = useState( false );
	const [ forgotMessage, setForgotMessage ] = useState( false );
	const doAjaxCall = useAjaxCall();
	useEffect( () => {
		if ( 'undefined' !== data && ! isLoading ) {
			const { license, status, altServer, message } = data;
			dispatch( setLicenseKey( license || '' ) );
			dispatch( setAltServer( altServer || false ) );
			dispatch( setStatus( status || '' ) );
			dispatch( setMessage( message || false ) );
		}
	}, [ state.activeTab, dispatch, data, isLoading ] );

	if ( 'undefined' === data || isLoading ) {
		return;
	}

	const handleClick = async () => {
		let licenseData = {};
		setActionLoading( true );
		if ( state?.status?.license !== 'valid' ) {
			setActionMessage( __( 'Activating license…', 'modula-best-grid-gallery' ) );
			licenseData = {
				action: 'modula_save_license',
				// eslint-disable-next-line no-undef
				license_security: modulaData.nonce,
				license: state.licenseKey,
				altServer: state.altServer,
			};
		} else {
			setActionMessage( __( 'Deactivating license…', 'modula-best-grid-gallery' ) );
			licenseData = {
				action: 'modula_deactivate_license',
				// eslint-disable-next-line no-undef
				license_security: modulaData.nonce,
				altServer: state.altServer,
			};
		}

		const response = await doAjaxCall( licenseData, true );

		setActionMessage( response );

		setTimeout( () => {
			setActionMessage( false );
		}, 2000 );

		setActionLoading( false );
	};

	const handleForgotClick = async () => {
		let licenseData = {};
		setForgotLoading( true );

		setForgotMessage( __( 'Retrieving data…', 'modula-best-grid-gallery' ) );
		licenseData = {
			action: 'modula_resend_license',
			// eslint-disable-next-line no-undef
			license_security: modulaData.nonce,
			license_email: licenseEmail,
			altServer: state.altServer,
		};

		const response = await doAjaxCall( licenseData, true );

		setForgotMessage( response.data );

		setTimeout( () => {
			setForgotMessage( false );
		}, 2000 );

		setForgotLoading( false );
	};

	return (
		<div className="modula_license_inputs_container">
			<div className="modula_license_button_wrapp">
				<span className="modula_main_license_label">
					{ __( 'Your License', 'modula-best-grid-gallery' ) }
				</span>
				<div className="modula_license_actions">
					{ actionMessage && <span className="modula_action_loading" dangerouslySetInnerHTML={ { __html: actionMessage } } /> }
					<Button
						className="modula_license_button"
						onClick={ handleClick }
						disabled={ actionLoading }
					>
						{ actionLoading && <Spinner /> }
						{ state?.status?.license === 'valid'
							? __( 'Deactivate', 'modula-best-grid-gallery' )
							: __( 'Activate', 'modula-best-grid-gallery' )
						}
					</Button>
				</div>
			</div>
			<div className="modula_license_input_wrapp">
				<span className="modula_input_label">
					{ __( 'License Key', 'modula-best-grid-gallery' ) }
				</span>
				<TextControl
					type="password"
					className="modula_license_input"
					value={ state?.licenseKey }
					placeholder={ __( 'Your License Key', 'modula-best-grid-gallery' ) }
					onChange={ ( val ) => dispatch( setLicenseKey( val ) ) }
					disabled={ state?.status?.license === 'valid' }
				/>
				{ 'valid' !== state?.status?.license &&
					<Button
						className="modula_forgot_license_button"
						onClick={ () => setShowForgotLicense( ! showForgotLicense ) }
					>
						{ ! showForgotLicense
							? __( 'Forgot license?', 'modula-best-grid-gallery' )
							: __( 'Cancel', 'modula-best-grid-gallery' )
						}
					</Button>
				}
				<div className="modula_input_description_wrap">
					<span className="ibox">i</span>
					<p className="modula_input_description" dangerouslySetInnerHTML={ { __html: state.message } } />
				</div>
			</div>
			{ showForgotLicense &&
				<div className="modula_license_input_wrapp">
					<span className="modula_input_label">
						{ __( 'Email', 'modula-best-grid-gallery' ) }
					</span>
					<TextControl
						type="email"
						className="modula_license_input"
						value={ licenseEmail }
						onChange={ ( val ) => setLicenseEmail( val ) }
					/>
					<div className="modula_license_actions">
						{ forgotMessage && <span className="modula_action_loading" dangerouslySetInnerHTML={ { __html: forgotMessage } } /> }
						<Button
							className="modula_license_button"
							onClick={ handleForgotClick }
							disabled={ forgotLoading }
						>
							{ forgotLoading && <Spinner /> }
							{ __( 'Send Email', 'modula-best-grid-gallery' ) }
						</Button>
					</div>
				</div>
			}
			<div className="modula_license_input_wrapp">
				<span className="modula_input_label">
					{ __( 'Use Alternative Server', 'modula-best-grid-gallery' ) }
				</span>
				<ToggleField />
				<div className="modula_input_description_wrap">
					<span className="ibox">i</span>
					<p className="modula_input_description" >
						{ __( 'Sometimes there can be problems with the activation server, in which case please try the alternative one.', 'modula-best-grid-gallery' ) }
					</p>
				</div>
			</div>
		</div>
	);
}
