// External Dependencies
import React, {Component} from 'react';

// Internal Dependencies
import './style.css';


class ModulaDivi extends Component {

	static slug = 'modula_gallery';

	render () {

		return (
			<div dangerouslySetInnerHTML={{ __html: this.props.modula_images }}></div>

		);
	}
}

export default ModulaDivi;
