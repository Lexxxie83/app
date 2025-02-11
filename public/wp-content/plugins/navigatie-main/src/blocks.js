/* eslint-disable no-console */
/**
 * Gutenberg Blocks
 *
 * All blocks related JavaScript files should be imported here.
 * You can create a new block folder in this dir and include code
 * for that block here as well.
 *
 * All blocks should be included here since this is the file that
 * Webpack is compiling as the input file.
 */

 
/**
 * WordPress dependencies
 */
import {
	registerBlockType,
	unstable__bootstrapServerSideBlockDefinitions, // eslint-disable-line camelcase
} from '@wordpress/blocks';

/**
 * Internal dependencies
 * Hier kan een extra blok toegevoegd worden, die moet hieronder geregistreerd worden.
 */

// import * as faq from './faq';
import * as navigatie from './navigatie';
import * as socialmedia from './socialmedia';


/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}
	const { metadata, settings, name } = block;
	if ( metadata ) {
		unstable__bootstrapServerSideBlockDefinitions( { [ name ]: metadata } );
	}
	registerBlockType( name, settings );
};

/**
 * Function to register core blocks provided by the block editor.
 * test
 */
export const registerIndrukwekkendBlocks = () => {
	[
		// Common blocks are grouped at the top to prioritize their display
		// in various contexts — like the inserter and auto-complete components.
		// faq,
		navigatie,
		socialmedia,
	].forEach( registerBlock );
};

registerIndrukwekkendBlocks();
