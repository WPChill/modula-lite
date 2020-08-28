// External Dependencies
import React, {Component} from 'react';
import $ from 'jquery';

// Internal Dependencies
import './style.css';


class ModulaDivi extends Component {

	static slug = 'modula_gallery';

	constructor(props){
		super(props);
	}

	render () {
		return (
			<div dangerouslySetInnerHTML={{ __html: this.props.modula_images }}></div>
		);
	}

	componentDidUpdate( prevProps ){
		let id = '#jtg-' + this.props.gallery_select;

		if( $( id ).length > 0 ){
			let modulaSettings = $( id ).data( 'config' ),
			    modulaInstance = $( id ).data( 'plugin_modulaGallery' );

			if( ! modulaInstance ){
				$( id ).modulaGallery( modulaSettings );
			}
		} 

	}

}

export default ModulaDivi;
