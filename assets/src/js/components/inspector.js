import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { Button, PanelBody, PanelRow } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import ModulaGallerySearch from './ModulaGallerySearch';

/**
 * Inspector controls
 */
const Inspector = (props) => {
	const { attributes, galleries, onIdChange } = props;
	const { id, currentSelectize } = attributes;

	return (
		<InspectorControls>
			<PanelBody title={__('Gallery Settings', 'modula-best-grid-gallery')} initialOpen={true}>
				{galleries.length > 0 && (
					<Fragment>
						<ModulaGallerySearch id={id} key={id} value={id} options={currentSelectize} onIdChange={onIdChange} galleries={galleries} />
						{id != 0 && (
							<Button
								target="_blank"
								href={modulaVars.adminURL + 'post.php?post=' + id + '&action=edit'}
								variant="secondary"
							>
								{__('Edit gallery')}
							</Button>
						)}
					</Fragment>
				)}
			</PanelBody>
		</InspectorControls>
	);
};

export default wp.components.withFilters('modula.ModulaInspector')(Inspector);
