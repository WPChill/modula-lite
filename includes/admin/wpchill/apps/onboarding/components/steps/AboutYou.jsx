import { useWpchillState } from '../../state/use-wpchill-state';
import { SaveContinueButton } from '../SaveContinueButton.jsx';
import { setStepsData } from '../../state/actions';
import {
	RadioControl,
	TextControl,
	CheckboxControl,
	Button,
	__experimentalSpacer as Spacer,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './AboutYou.scss';

export function AboutYou() {
	const { state, dispatch } = useWpchillState();

	// get existing data for current step
	const currentData = state.stepsData[ state.step ] || {};

	const updateField = ( key, value ) => {
		const updated = {
			...currentData,
			[ key ]: value,
		};
		dispatch( setStepsData( updated ) );
	};

	return (
		<div className="wpchill-aboutyou">
			<div className="wpchill-aboutyou-body">
				<h2 className="wpchill-aboutyou-title">
					{ __( 'What best describes you?', 'wpchill' ) }
				</h2>

				<p className="wpchill-aboutyou-subtitle">
					{ __(
						'Tell us a bit about this website to help us craft the perfect experience for you.',
						'wpchill',
					) }
				</p>

				<div className="wpchill-aboutyou-radios">
					<RadioControl
						label={ __( 'Select your role', 'wpchill' ) }
						selected={ currentData.role }
						options={ [
							{ label: __( 'Photographer / Artist', 'wpchill' ), value: 'photographer' },
							{ label: __( 'Web Developer / Designer', 'wpchill' ), value: 'developer' },
							{ label: __( 'Marketer', 'wpchill' ), value: 'marketer' },
							{ label: __( 'Blogger', 'wpchill' ), value: 'blogger' },
							{ label: __( 'Business Store Owner', 'wpchill' ), value: 'store-owner' },
							{ label: __( 'Something Else', 'wpchill' ), value: 'other' },
						] }
						onChange={ ( value ) => updateField( 'role', value ) }
					/>
				</div>

				<Spacer marginTop={ 5 } />

				<h3 className="wpchill-aboutyou-sectiontitle">
					{ __( 'Join the WPChill Community', 'wpchill' ) }
				</h3>

				<TextControl
					label={ __( 'Email Address', 'wpchill' ) }
					value={ currentData.email || '' }
					onChange={ ( value ) => updateField( 'email', value ) }
					placeholder={ __( 'you@example.com', 'wpchill' ) }
				/>

				<CheckboxControl
					label={ __(
						'I agree to receive important communications from WPChill.',
						'wpchill',
					) }
					checked={ !! currentData.agreeEmails }
					onChange={ ( value ) => updateField( 'agreeEmails', value ) }
				/>

				<CheckboxControl
					label={ __(
						'Help us better understand our users and their website needs.',
						'wpchill',
					) }
					checked={ !! currentData.helpUnderstand }
					onChange={ ( value ) => updateField( 'helpUnderstand', value ) }
				/>
			</div>

			<div className="wpchill-aboutyou-footer">
				<Button variant="tertiary" className="wpchill-aboutyou-back">
					← { __( 'Go Back', 'wpchill' ) }
				</Button>

				<SaveContinueButton keyName="about-you" />
			</div>
		</div>
	);
}
