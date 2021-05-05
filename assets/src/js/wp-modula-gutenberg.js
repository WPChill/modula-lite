/**
 * Internal dependencies
 */
import Edit from './components/edit';
import icons from './utils/icons';
import style from '../scss/modula-gutenberg.scss';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

class ModulaGutenberg {
	constructor() {
		this.registerBlock();
	}

	registerBlock() {
		this.blockName = 'modula/gallery';

		this.blockAttributes = {
			id: {
				type: 'number',
				default: 0
			},
			images: {
				type: 'array',
				default: []
			},
			status: {
				type: 'string',
				default: 'ready'
			},
			galleryId: {
				type: 'number',
				default: 0
			},
			defaultSettings: {
				type: 'object',
				default: []
			},
			galleryType: {
				type: 'string',
				default: 'none'
			},
			// Attribut for current gallery
			currentGallery: {
				type: 'object',
				default: {}
			},
			// Attribut for current gallery option in selectize
			currentSelectize: {
				type: 'array',
				default: []
			}
		};

		registerBlockType(this.blockName, {
			title: modulaVars.gutenbergTitle,
			icon: icons.modula,
			description: __('Make your galleries stand out.', 'modula-best-grid-gallery'),
			keywords: [ __('gallery'), __('modula'), __('images') ],
			category: 'common',
			supports: {
				align: true,
				customClassName: false
			},
			attributes: this.blockAttributes,
			// getEditWrapperProps() {
			// 	return {
			// 		'data-align': 'full'
			// 	};
			// },
			edit: Edit,
			save() {
				// Rendering in PHP
				return null;
			}
		});
	}
}

let modulaGutenberg = new ModulaGutenberg();
