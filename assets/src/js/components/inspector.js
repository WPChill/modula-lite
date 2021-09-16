import ModulaGallerySearch from './ModulaGallerySearch';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { Button, PanelBody } = wp.components;

/**
 * Inspector controls
 */
const Inspector = (props) => {
	const { attributes, galleries, onIdChange } = props;
	const { id, currentSelectize } = attributes;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={__('Gallery Settings', 'modula-best-grid-gallery')} initialOpen={true}>
					{galleries.length > 0 && (
						<Fragment>
							<ModulaGallerySearch id={id} key={id} value={id} options={currentSelectize} onIdChange={onIdChange} galleries={galleries}/>
							{id != 0 && (
								<Button
									target="_blank"
									href={modulaVars.adminURL + 'post.php?post=' + id + '&action=edit'}
									isSecondary
								>
									{__('Edit gallery')}
								</Button>
							)}
						</Fragment>
					)}
				</PanelBody>
			</InspectorControls>
		</Fragment>
	);
};

export default wp.components.withFilters('modula.ModulaInspector')(Inspector);
