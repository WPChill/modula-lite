/**
 * Internal dependencies
 */
import Inspector from './inspector';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { withSelect } = wp.data;
const { SelectControl, Button, Spinner, Toolbar, IconButton } = wp.components;
const { BlockControls } = wp.editor;

class ModulaEdit extends Component {

	constructor( props ) {
		super( ...arguments );

		this.props.attributes.status = 'ready';
		this.props.attributes.images = [];
	}

	componentDidMount() {
		if( this.props.attributes.id !== 0 ) {
			this.onIdChange( this.props.attributes.id );
		}
	}

	onIdChange( id ) {
		this.props.setAttributes( { status: 'loading' } );

		jQuery.ajax({
			type: "POST",
			data : { action: "modula_get_gallery_meta", id: id, nonce: modulaVars.nonce },
			url : modulaVars.ajaxURL,
			success: ( result ) => this.onGalleryLoaded( id, result ),
		});
	}

	onGalleryLoaded( id, result ) {
		if( result.success === false ) {
			this.props.setAttributes( { id: 0, status: 'ready' } );
			return;
		}

		this.props.setAttributes( { id: id, images: JSON.parse( result ), status: 'ready' } );
	}

	selectOptions() {
		let options = [ { value: 0, label: __( 'select a gallery', 'modula-best-grid-gallery' ) } ];

		this.props.galleries.forEach(function( gallery ) {
			if( gallery.title.rendered.length == 0 ) {
				options.push( {
					value: gallery.id,
					label: __( 'Unnamed Gallery ', 'modula-best-grid-gallery' ) + gallery.id
				} );
			} else {
				options.push( { value: gallery.id, label: gallery.title.rendered } );
			}
		});

		return options;
	}

	render() {
 		const { attributes, galleries } = this.props;
		const { id, images, status } = attributes;

		const blockControls = (
			<BlockControls>
				{ images.length > 0 && (
					<Toolbar>
						<IconButton
							label={ __( 'Edit gallery','modula-best-grid-gallery' ) }
							icon="edit"
							href={ modulaVars.adminURL + 'post.php?post=' + id + '&action=edit' }
							target="_blank"
						/>
					</Toolbar>
				) }
			</BlockControls>
		);

		if( status === 'loading' ) {
			return [
				<Fragment>
					<div className="modula-block-preview">
						<div className="modula-block-preview__content">
							<div className="modula-block-preview__logo"></div>
							<Spinner/>
						</div>
					</div>
				</Fragment>
			];
		}

		if( id == 0 || images.length === 0 ) {
			return [
				<Fragment>
					<Inspector onIdChange={ ( id ) => this.onIdChange( id ) } { ...this.props } />

					<div className="modula-block-preview">
						<div className="modula-block-preview__content">
							<div className="modula-block-preview__logo"></div>
							{ ( galleries.length === 0 ) && (
								<Fragment>
									<p>{ __( 'You don\'t seem to have any galleries.','modula-best-grid-gallery' ) }</p>
									<Button href={ modulaVars.adminURL + 'post-new.php?post_type=modula-gallery' } target="_blank" isDefault>{ __( 'Add New Gallery','modula-best-grid-gallery' ) }</Button>
								</Fragment>
							)}
							{ ( galleries.length > 0 ) && (
								<Fragment>
									<SelectControl
										key={id}
										value={ id }
										options={ this.selectOptions() }
										onChange={ ( value ) => this.onIdChange( parseInt( value ) ) }
									/>
									{ id != 0 && (
										<Button target="_blank" href={ modulaVars.adminURL + 'post.php?post=' + id + '&action=edit' } isPrimary>{ __( 'Edit Gallery' ) }</Button>
									) }
								</Fragment>
							)}
						</div>
					</div>

				</Fragment>
			];
		}

		return [
			<Fragment>
				{ blockControls }
				<Inspector onIdChange={ ( id ) => this.onIdChange( id ) } { ...this.props } />

				<div className="modula-block-preview--images">
					{ images.map( ( img, index ) => {
						return [
							<div className="modula-preview-image-wrap">
								<img src={ img.src } />
							</div>
						];
					} ) }
				</div>

			</Fragment>
		];
	}
}



export default withSelect( ( select, props ) => {
	const { getEntityRecords } = select( 'core' );
	const query = {
		post_status: 'publish',
		per_page: -1,
	}

	return {
		galleries: getEntityRecords( 'postType', 'modula-gallery', query ) || [],
	};
} )( ModulaEdit );


