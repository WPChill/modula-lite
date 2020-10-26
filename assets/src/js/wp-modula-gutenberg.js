/**
 * Internal dependencies
 */
import Edit from './components/edit';
import icons from './utils/icons';
/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { createHooks } = wp.hooks;

var modulaHooks = createHooks();


class ModulaGutenberg  {

	constructor() {
		this.registerBlock();
	}

	registerBlock() {

		this.blockName = 'modula/gallery';

		this.blockAttributes = {
			id: {
				type: 'number',
				default: 0,
			},
		};

		registerBlockType( this.blockName, {
			title: __( 'Modula Gallery', 'modula-best-grid-gallery'),
			icon: modulaHooks.applyFilters( 'modulaSvgIcon', icons.modula),
			description: __( 'Make your galleries stand out.','modula-best-grid-gallery' ),
			keywords: [
				__( 'gallery' ),
				__( 'modula' ),
				__( 'images' ),
			],
			category: 'common',
			supports: {
				align: [ 'wide', 'full' ],
				customClassName: false,
			},
			attributes: this.blockAttributes,
			edit: Edit,
			save() {
				// Rendering in PHP
				return null;
			},
		} );

	}

}

let modulaGutenberg = new ModulaGutenberg();