<?php
/**
 * Server-side rendering of the `indrukwekkend/socialmedia` block.
 *
 * @package WordPress
 */

/**
 * Renders the `indrukwekkend/socialmedia` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 * 
 *  based on https://codepen.io/Coding_Journey/pen/RwNgYmm
 * 
 */

function render_block_indrukwekkend_socialmedia( $attributes ) {

	$socials = '';

	 // Footer contact informatie
	 $contact_text = get_field('opt_foot_contact_text', 'option');
	 if( have_rows('opt_foot_contact_info', 'option') ):
		 while( have_rows('opt_foot_contact_info', 'option') ): the_row(); 
 
			 $linkedin = get_sub_field('linkedin', 'option');
			 $pinterest = get_sub_field('pinterest', 'option');
			 $facebook = get_sub_field('facebook', 'option');
			 $instagram = get_sub_field('instagram', 'option');
			 $twitter = get_sub_field('twitter', 'option');
			 $youtube = get_sub_field('youtube', 'option');
			 $website = get_sub_field('website', 'option');
		 endwhile;

	 if ($linkedin) :
		$socials .=
			"<a target='_blank' href='$linkedin' title='LinkedIn'>
				<i class='fab fa-linkedin'></i>
			</a>";
	 endif;
	if ($pinterest) :
		$socials .=
		"<a target='_blank' href='$pinterest' title='Pinterest'>
			<i class='fab fa-pinterest-square'></i>
		</a>";
	endif ;
	if ($facebook) :
		$socials .=
	"<a target='_blank' href='$facebook' title='Facebook'>
			<i class='fab fa-facebook-square'></i>
		</a>";
	endif ;
	if ($instagram) :
		$socials .=
		"<a target='_blank' href='$instagram' title='Instagram'>
			<i class='fab fa-instagram-square'></i>
		</a>";
	endif ;
	if ($twitter) :
		$socials .=
		"<a target='_blank' href='$twitter' title='Twitter'>
			<i class='fab fa-twitter-square'></i>
		</a>";
	endif ;
	if ($youtube) :
		$socials .=
		"<a target='_blank' href='$youtube' title='YouTube'>
			<i class='fab fa-youtube-square'></i>
		</a>";
	endif ;

endif; // object have_rows

	//output
	return sprintf(
		'<div class="socials">
			%1$s
		</div>',
		$socials,
	);
}

/**
 * Registers the `indrukwekkend/faq` block on server.
 */
function register_block_indrukwekkend_socialmedia() {
	register_block_type(
		'indrukwekkend/socialmedia',
		array(
			'attributes'      => array(
				'className'               => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'render_block_indrukwekkend_socialmedia',
		)
	);
}
add_action( 'init', 'register_block_indrukwekkend_socialmedia' );