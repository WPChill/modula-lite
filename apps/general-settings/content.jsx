import { Panel, PanelBody } from '@wordpress/components';
import useStateContext from './context/useStateContext';
import { useTabsQuery } from './query/useTabsQuery';
import SettingsForm from './SettingsForm';
import SaveButton from './SaveButton';

export default function Content() {
	const { state } = useStateContext();
	const { data, isLoading } = useTabsQuery();

	if ( ! data || isLoading ) {
		return null;
	}

	const activeTab = data.find( ( tab ) => tab.slug === state.activeTab );

	if ( ! activeTab || ! activeTab.subtabs ) {
		return null;
	}

	return (
		<div className="modula-page-content">
			<Panel className="modula-accordion-wrapper" header={ activeTab.label }>
				{ Object.entries( activeTab.subtabs ).map( ( [ subtabSlug, subtabData ] ) => {
					if ( ! subtabData || Object.keys( subtabData ).length === 0 ) {
						return null;
					}

					return (
						<PanelBody
							className="modula-accordion-pannel"
							key={ subtabSlug }
							title={
								<span className="modula-accordion-title">
									<span className="modula-triangle-icon" />
									<span>{ subtabData.label }</span>
									{ subtabData.badge && (
										<span className="modula-pro-badge"> { subtabData.badge } </span>
									) }
								</span>
							}
							initialOpen={ true }
						>
							<SettingsForm config={ subtabData?.config || {} } />
						</PanelBody>
					);
				} ) }
				{ ( typeof activeTab.save === 'undefined' || activeTab.save !== false ) && (
					<SaveButton />
				) }
			</Panel>
		</div>
	);
}
