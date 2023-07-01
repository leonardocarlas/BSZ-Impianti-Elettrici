<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Everest
 * @since Catch Everest 1.0
 */


if ( ! function_exists( 'catcheverest_header_meta_BSZ' ) ) :
/**
 * Prints HTML with meta information for the normal post header: date and author
 *
 * Create your own catcheverest_header_meta() to override in a child theme.
 *
 * @since Catch Everest 1.0
 */
function catcheverest_header_meta_BSZ() {
	
	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	
	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'catcheverest' ), get_the_author() ) ),
		get_the_author()
	);
	
	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
		//$utility_text = __( '<span class="on-date">Posted on %1$s</span><span class="by-author"> by %2$s</span>', 'catcheverest' );

		$utility_text = __( '<span class="on-date">Pubblicato il %1$s</span>', 'catcheverest' );

		
	printf(
		$utility_text,$date,""
		//,		$date
		//,$author
	);
}
endif;

