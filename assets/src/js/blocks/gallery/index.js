import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import metadata from './block.json';
import icons from '../../utils/icons';

registerBlockType( metadata.name, {	icon: icons.modula, edit: Edit } );
