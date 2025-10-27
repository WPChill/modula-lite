import { useWpchillState } from '../../state/use-wpchill-state';
import { SaveContinueButton } from '../SaveContinueButton.jsx';
import { GoBackButton } from '../GoBackButton.jsx';
import { setStepsData } from '../../state/actions';
import { CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './Features.scss';

export function Features() {
	const { state, dispatch } = useWpchillState();
	const stepKey = 'features';
	const currentData = state.stepsData[ stepKey ] || { enabled: [] };

	const updateField = ( value ) => {
		const updated = { ...currentData };
		const enabled = new Set( updated.enabled || [] );

		if ( enabled.has( value ) ) {
			enabled.delete( value );
		} else {
			enabled.add( value );
		}

		dispatch( setStepsData( { [ stepKey ]: { enabled: Array.from( enabled ) } } ) );
	};

	const isChecked = ( value ) => {
		const baseFree = [ 'responsive', 'dragdrop', 'lightbox' ];
		return baseFree.includes( value ) || ( currentData.enabled || [] ).includes( value );
	};

	const features = [
		{
			key: 'responsive',
			label: __( 'Responsive Photo Galleries', 'wpchill' ),
			desc: __( 'Create beautiful fully responsive galleries which are cross-browser compatible.', 'wpchill' ),
			disabled: true,
		},
		{
			key: 'dragdrop',
			label: __( 'Drag and Drop', 'wpchill' ),
			desc: __( 'Easily add, remove, and reorder gallery images with drag and drop simplicity.', 'wpchill' ),
			disabled: true,
		},
		{
			key: 'lightbox',
			label: __( 'Lightboxes', 'wpchill' ),
			desc: __( 'Showcase your galleries in beautiful lightboxes that look great on every device.', 'wpchill' ),
			disabled: true,
		},
		{
			key: 'albums',
			label: __( 'Albums & Tags (PRO)', 'wpchill' ),
			desc: __( 'Organize and label galleries so visitors can find exactly what they’re looking for.', 'wpchill' ),
			disabled: false,
		},
		{
			key: 'video',
			label: __( 'Video Galleries (PRO)', 'wpchill' ),
			desc: __( 'Increase engagement by embedding videos in your galleries.', 'wpchill' ),
			disabled: false,
		},
		{
			key: 'slideshows',
			label: __( 'Slideshows (PRO)', 'wpchill' ),
			desc: __( 'Create beautiful customizable slideshows with your images.', 'wpchill' ),
			disabled: false,
		},
		{
			key: 'proofing',
			label: __( 'Proofing and eCommerce (PRO)', 'wpchill' ),
			desc: __( 'Allow your customers to proof and purchase images directly from you.', 'wpchill' ),
			disabled: false,
		},
	];

	return (
		<div className="wpchill-features">
			<div className="wpchill-features-body">
				<h2 className="wpchill-features-title">
					{ __( 'What WPChill features do you want to enable?', 'wpchill' ) }
				</h2>

				<p className="wpchill-features-subtitle">
					{ __(
						'We have already selected our recommended features, but you can enable other features below.',
						'wpchill'
					) }
				</p>

				<div className="wpchill-features-list">
					{ features.map( ( feature, i ) => (
						<div
							key={ feature.key }
							className={`wpchill-feature-item ${ feature.disabled ? 'is-disabled' : '' }`}
						>
							<div className="wpchill-feature-text">
								<div className="wpchill-feature-label">{ feature.label }</div>
								<div className="wpchill-feature-desc">{ feature.desc }</div>
							</div>

							<div className="wpchill-feature-checkbox">
								<CheckboxControl
									checked={ isChecked( feature.key ) }
									disabled={ feature.disabled }
									onChange={ () => updateField( feature.key ) }
								/>
							</div>
						</div>
					) ) }
				</div>
			</div>

			<div className="wpchill-features-footer">
				<GoBackButton />
				<SaveContinueButton keyName={ stepKey } />
			</div>
		</div>
	);
}
