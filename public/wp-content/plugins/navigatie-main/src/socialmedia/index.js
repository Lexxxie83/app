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

export const name = 'indrukwekkend/socialmedia';

export const settings = {
	title: __( 'socialmedia' ),
	icon: 'share',
	category: 'indrukwekkend',
	keywords: [ __( 'socialmedia' ), __( 'post' ) ],
	supports: {
		html: false,
	},
	edit,
	//Collapse,
};

