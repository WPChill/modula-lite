// External Dependencies
import React, {Component} from 'react';
import $ from 'jquery';

// Internal Dependencies
import './style.css';


class ModulaDivi extends Component {

	static slug = 'modula_gallery';

	render () {

		return (
			<div dangerouslySetInnerHTML={{ __html: this.props.modula_images }}></div>
		);
	}

	componentDidMount () {

		var modulaGalleries = $( '.modula.modula-gallery' );

		$.each( modulaGalleries, function () {

			var modulaID       = $( this ).attr( 'id' ),
			    modulaSettings = $( this ).data( 'config' );

			$( '#' + modulaID ).modulaGallery( modulaSettings );

		} );
	}

}

export default ModulaDivi;
