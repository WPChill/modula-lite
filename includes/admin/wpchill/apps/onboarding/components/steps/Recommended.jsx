import { useState, useEffect } from 'react';
import { useWpchillState } from '../../state/use-wpchill-state';
import { SaveContinueButton } from '../SaveContinueButton.jsx';
import { GoBackButton } from '../GoBackButton.jsx';
import { CheckboxControl, Spinner } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './Recommended.scss';
import { useGetOnboardingRecommended } from '../../query/useGetOnboardingRecommended';

export function Recommended() {
	const { state } = useWpchillState();
	const { data, isLoading, error } = useGetOnboardingRecommended( state.source );
	const [ localPlugins, setLocalPlugins ] = useState( [] );

	useEffect( () => {
		if ( data?.recommended ) {
			setLocalPlugins( data.recommended );
		}
	}, [ data ] );

	const togglePlugin = ( slug ) => {
		setLocalPlugins( ( prev ) =>
			prev.map( ( plugin ) => {
				if ( plugin.slug === slug ) {
					if ( plugin.status === 'active' ) {
						return plugin;
					}
					return {
						...plugin,
						status:
							plugin.status === 'installed'
								? 'not-installed'
								: 'installed',
					};
				}
				return plugin;
			} )
		);
	};

	if ( isLoading ) {
		return (
			<div className="wpchill-recommended-loading">
				<Spinner />
			</div>
		);
	}

	if ( error ) {
		return (
			<div className="wpchill-recommended-error">
				{ __( 'Failed to load recommended plugins.', 'wpchill' ) }
			</div>
		);
	}

	const plugins = localPlugins || [];

	return (
		<div className="wpchill-recommended">
			<div className="wpchill-recommended-body">
				<h2 className="wpchill-recommended-title">
					{ __( 'Add Recommended Features to Grow Your Website', 'wpchill' ) }
				</h2>

				<p className="wpchill-recommended-subtitle">
					{ __(
						'We have already selected our recommended features based on your site category, but you can choose other features below.',
						'wpchill'
					) }
				</p>

				<div className="wpchill-recommended-list">
					{ plugins.map( ( plugin ) => (
						<div key={ plugin.slug } className="wpchill-recommended-item">
							<div className="wpchill-recommended-text">
								<div className="wpchill-recommended-label">{ plugin.title }</div>
								<div className="wpchill-recommended-desc">{ plugin.description }</div>
							</div>

							<div className="wpchill-recommended-checkbox">
								<CheckboxControl
									checked={ plugin.status === 'active' || plugin.status === 'installed' }
									disabled={ plugin.status === 'active' }
									onChange={ () => togglePlugin( plugin.slug ) }
								/>
							</div>
						</div>
					) ) }
				</div>
			</div>

			<div className="wpchill-recommended-footer">
				<GoBackButton />
				<SaveContinueButton keyName="recommended" />
			</div>
		</div>
	);
}
