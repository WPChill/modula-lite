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
export default class Inspector extends Component {

	constructor( props ) {
		super( ...arguments );
	}

	selectOptions() {
		let options = [ { value: 0, label: __( 'none' ) } ];

		this.props.galleries.forEach(function( gallery ) {
			options.push( { value: gallery.id, label: gallery.title.rendered } );
		});

		return options;
	}

	render() {
		const { attributes, setAttributes, galleries } = this.props;
		const { id } = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Gallery Settings' ) } initialOpen={ true }>
						{ galleries.length === 0 && (
							<Fragment>
								<p>{ __( 'You don\'t seem to have any galleries.' ) }</p>
								<Button href={ modulaVars.adminURL + 'post-new.php?post_type=modula-gallery' } target="_blank" isDefault>{ __( 'Add New Gallery' ) }</Button>
							</Fragment>
						)}

						{ galleries.length > 0 && (
							<Fragment>
								<SelectControl
									label={ __( 'Select Gallery' ) }
									value={ id }
									options={ this.selectOptions() }
									onChange={ ( value ) => this.props.onIdChange( parseInt( value ) ) }
								/>
								{ id != 0 && (
									<Button target="_blank" href={ modulaVars.adminURL + 'post.php?post=' + id + '&action=edit' } isDefault>{ __( 'Edit gallery' ) }</Button>
								) }
							</Fragment>
						)}

					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	}
}