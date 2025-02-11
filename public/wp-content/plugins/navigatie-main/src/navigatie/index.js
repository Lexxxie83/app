/**
 * BLOCK: indrukwekkend-blocks
 *
 * Registering a basic block with Gutenberg.
 */

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

//  Import CSS.
import './editor.scss';
import './style.scss';
/**
 * Internal dependencies
 */ 
import edit from './edit';

export const name = 'indrukwekkend/navigatie';

export const settings = {
	title: __( 'navigatie' ),
	icon: 'format-chat',
	category: 'indrukwekkend',
	keywords: [ __( 'navigatie' ), __( 'post' ) ],
	supports: {
		align: [ 'wide', 'full' ],
		html: false,
	},
	edit,
	//Collapse,
};

