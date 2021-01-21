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
			isGallery: {
				type: 'boolean',
				default: true
			},
			images: {
				type: 'array',
				default: []
			},
			status: {
				type: 'string',
				default: 'deciding'
			},

			galleryId: {
				type: 'number',
				default: 0
			},
			defaultSettings: {
				type: 'object',
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
				align: [ 'wide', 'full' ],
				customClassName: false
			},
			attributes: this.blockAttributes,
			getEditWrapperProps() {
				return {
					'data-align': 'full'
				};
			},
			edit: Edit,
			save() {
				// Rendering in PHP
				return null;
			}
		});
	}
}

let modulaGutenberg = new ModulaGutenberg();
