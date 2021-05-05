import ModulaGallerySearch from './ModulaGallerySearch';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { InspectorControls } = wp.editor;
const { SelectControl, Button, PanelBody } = wp.components;

/**
 * Inspector controls
 */
const Inspector = (props) => {
	const { attributes, setAttributes, galleries, onIdChange } = props;
	const { id, currentGallery, currentSelectize } = attributes;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={__('Gallery Settings', 'modula-best-grid-gallery')} initialOpen={true}>
					{galleries.length > 0 && (
						<Fragment>
							<ModulaGallerySearch id={id} key={id} value={id} options={currentSelectize} onIdChange={onIdChange} />
							{id != 0 && (
								<Button
									target="_blank"
									href={modulaVars.adminURL + 'post.php?post=' + id + '&action=edit'}
									isDefault
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
