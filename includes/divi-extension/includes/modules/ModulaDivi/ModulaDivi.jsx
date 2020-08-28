// External Dependencies
import React, {Component} from 'react';
import $ from 'jquery';
import { findDOMNode } from 'react-dom';

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
		this._setup_modula();
	}

	_setup_modula(){
		const grid = findDOMNode(this.refs.grid);
		console.log($(findDOMNode(this)));
		if (!grid) return;

		/*if(this.masonry){
			this.masonry.masonry('destroy');
		}

		this.masonry = $(grid).dss_masonry_gallery();

		this.resizeObserver = new ResizeObserver(entries => {
			this.masonry.masonry('layout');
		});

		this.resizeObserver.observe(grid);
		this._fix_overlay_icon();*/
		//console.log("MasonryGallery._setup_masonry:  end", this.props.moduleInfo.address);
	}

}

export default ModulaDivi;
