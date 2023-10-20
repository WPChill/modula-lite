/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';
import { ModulaIcon } from './utils/icons';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,
	icon: ModulaIcon(),
	deprecated: [
		{
			attributes: {
				id: {
					type: 'number',
					default: 0,
				},
				images: {
					type: 'array',
					default: [],
				},
				status: {
					type: 'string',
					default: 'ready',
				},
				galleryId: {
					type: 'number',
					default: 0,
				},
				defaultSettings: {
					type: 'object',
					default: [],
				},
				galleryType: {
					type: 'string',
					default: 'none',
				},
				currentGallery: {
					type: 'object',
					default: {},
				},
				currentSelectize: {
					type: 'array',
					default: [],
				},
			},
			save() {
				return null;
			},
		},
	],
});
