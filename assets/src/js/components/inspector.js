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
	const { attributes, setAttributes, galleries } = props;
	const { id } = attributes;

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={__('Gallery Settings', 'modula-best-grid-gallery')} initialOpen={true}>
					{galleries.length > 0 && (
						<Fragment>
							<SelectControl
								key={id}
								label={__('Select Gallery', 'modula-best-grid-gallery')}
								value={id}
								options={props.selectOptions()}
								onChange={(value) => props.onIdChange(parseInt(value))}
							/>
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
