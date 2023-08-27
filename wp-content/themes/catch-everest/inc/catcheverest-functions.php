<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Themes
 * @subpackage Catch Everest
 * @since Catch Everest 1.0
 */

/**
 * Enqueue scripts and styles
 */
function catcheverest_scripts() {
	$theme = wp_get_theme();

	//Getting Ready to load data from Theme Options Panel
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

	/**
	 * Loads up main stylesheet.
	 */
	wp_enqueue_style( 'catcheverest-style', get_stylesheet_uri(), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );

	// Theme block stylesheet.
	wp_enqueue_style( 'catcheverest-block-style', get_theme_file_uri( '/css/blocks.css' ), array( 'catcheverest-style' ), '1.0' );

	/**
	 * Add Genericons font, used in the main stylesheet.
	 */
	wp_enqueue_style( 'genericons', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'genericons/genericons.css', array(), '3.4.1' );

	/**
	 * Loads up Responsive stylesheet and Menu JS
	 */
	$disable_responsive = $options['disable_responsive'];

	if ( $disable_responsive == "0" ) {
		wp_enqueue_style( 'catcheverest-responsive', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/responsive.css', false, $theme->get( 'Version' ) );
		wp_enqueue_script( 'catcheverest-menu', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/catcheverest-menu.min.js', array( 'jquery' ),  wp_get_theme()->get('Version'), true );

		wp_localize_script( 'catcheverest-menu', 'catchEverestOptions', array(
			'screenReaderText' => array(
				'expand'   => esc_html__( 'expand child menu', 'catch-everest' ),
				'collapse' => esc_html__( 'collapse child menu', 'catch-everest' ),
			),
		) );
	}

	wp_enqueue_script( 'catcheverest-navigation', get_template_directory_uri() . '/js/navigation.min.js', array( 'jquery' ), '20150601', true );

	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	/**
	 * Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	 */
	wp_register_script( 'jquery-cycle', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle.all.min.js', array( 'jquery' ), '2.9999.5', true );

	/**
	 * Loads up catcheverest-slider and jquery-cycle set up as dependent on catcheverest-slider
	 */
	$enableslider = $options['enable_slider'];
	if ( ( 'enable-slider-allpage' == $enableslider ) || ( ( is_front_page() || ( is_home() && is_front_page() ) ) && 'enable-slider-homepage' == $enableslider ) ) {
		wp_enqueue_script( 'catcheverest-slider', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/catcheverest-slider.js', array( 'jquery-cycle' ), '20130114', true );
	}

	/**
	 * Loads up Scroll Up script
	 */
	if ( empty( $options['disable_scrollup'] ) ) {
		wp_enqueue_script( 'catcheverest-scrollup', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/catcheverest-scrollup.min.js', array( 'jquery' ), '20072014', true  );
	}

	/**
	 * Browser Specific Enqueue Script
	 */
	wp_enqueue_script( 'catcheverest-html5', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/html5.min.js', array(), '3.7.3' );
	wp_script_add_data( 'catcheverest-html5', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'catcheverest_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 */
function catcheverest_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'catcheverest-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/editor-blocks.css' );
	// Add custom fonts.
}
add_action( 'enqueue_block_editor_assets', 'catcheverest_block_editor_styles' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Catch Everest 1.0
 */
function catcheverest_responsive() {
	// Getting data from Theme Options
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;
	$disable_responsive = $options['disable_responsive'];

	if ( $disable_responsive == "0" ) {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
	}
}
add_action( 'wp_head', 'catcheverest_responsive', 5 );


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Catch Everest 1.0
 * @remove when WordPress version 5.0 is released
 */
function catcheverest_inline_css() {
	//delete_transient( 'catcheverest_inline_css' );
	/**
	 * Bail if WP version >=4.7 as we have migrated this option to core
	 */
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		return;
	}

	if ( ( !$output = get_transient( 'catcheverest_inline_css' ) ) ) {
		// Getting data from Theme Options
		global $catcheverest_options_settings;
   		$options = $catcheverest_options_settings;

		echo '<!-- refreshing cache -->' . "\n";
		if ( !empty( $options['custom_css'] ) ) {
			$output	.= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $output .= '<style type="text/css" media="screen">' . "\n";
			$output .=  $options['custom_css'] . "\n";
			$output .= '</style>' . "\n";
		}

		set_transient( 'catcheverest_inline_css', $output, 86940 );
	}

	echo $output;
}
add_action('wp_head', 'catcheverest_inline_css');


if ( ! function_exists( 'catcheverest_skip_content' ) ) :
/**
 * Display Featured Header Image
 */
function catcheverest_skip_content() { ?>
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'catch-everest' ); ?></a>
<?php
} // catcheverest_skip_content
endif;
add_action( 'catcheverest_before_header', 'catcheverest_skip_content', 5 );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Catch Everest 1.0
 */
function catcheverest_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'catcheverest_page_menu_args' );


/**
 * Removes div from wp_page_menu() and replace with ul.
 *
 * @since Catch Everest 1.0
 */
function catcheverest_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter('wp_page_menu', 'catcheverest_wp_page_menu');


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function catcheverest_excerpt_length( $length ) {
	// Getting data from Theme Options
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

	return $options['excerpt_length'];
}
add_filter( 'excerpt_length', 'catcheverest_excerpt_length' );


/**
 * Returns a "Continue Reading" link for excerpts
 */
function catcheverest_continue_reading() {
	// Getting data from Theme Options
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

	$more_tag_text = $options['more_tag_text'];

	return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' .  $more_tag_text . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with catcheverest_continue_reading().
 *
 */
function catcheverest_excerpt_more( $more ) {
	return catcheverest_continue_reading();
}
add_filter( 'excerpt_more', 'catcheverest_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function catcheverest_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= catcheverest_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'catcheverest_custom_excerpt' );


/**
 * Replacing Continue Reading link to post content more.
 *
 * function tied to the the_content_more_link filter hook.
 */
function catcheverest_more_link( $more_link, $more_link_text ) {
	// Getting data from Theme Options
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

	$more_tag_text = $options['more_tag_text'];

	return str_replace( $more_link_text, $more_tag_text, $more_link );
}
add_filter( 'the_content_more_link', 'catcheverest_more_link', 10, 2 );


/**
 * Redirect WordPress Feeds To FeedBurner
 */
function catcheverest_rss_redirect() {
	// Getting data from Theme Options
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

    if ($options['feed_url']) {
		$url = 'Location: '.$options['feed_url'];
		if ( is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT']))
		{
			header($url);
			header('HTTP/1.1 302 Temporary Redirect');
		}
	}
}
add_action('template_redirect', 'catcheverest_rss_redirect');


/**
 * Adds custom classes to the array of body classes.
 *
 * @since Catch Everest 1.0
 */
function catcheverest_body_classes( $classes ) {
	//Getting Ready to load data from Theme Options Panel
	global $catcheverest_options_settings;
	$options = $catcheverest_options_settings;

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$classes[] = catcheverest_get_theme_layout();

	return $classes;
}
add_filter( 'body_class', 'catcheverest_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Catch Everest 1.0
 */
function catcheverest_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'catcheverest_enhanced_image_navigation', 10, 2 );


if ( ! function_exists( 'catcheverest_header_left' ) ) :
/**
 * Shows Header Left content
 *
 * Shows the site logo, title and description
 * @uses catcheverest_header action to add it in the header
 */
function catcheverest_header_left() { ?>

        <div id="header-left">
            <?php
            // Check to see if the header image has been removed
			$header_image = get_header_image();

            // Check Logo
			if ( function_exists( 'has_custom_logo' ) ) {
				if ( has_custom_logo() ) { ?>
                	<div id="site-logo"><?php the_custom_logo(); ?></div>
                	<div id="hgroup" class="with-logo">
                <?php
				}
				else {
					echo '<div id="hgroup">';
				}
			}
			elseif ( ! empty( $header_image ) ) { ?>
                <div id="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                    <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
                </a></div>
                <div id="hgroup" class="with-logo">
            <?php
        	}
        	else {
                echo '<div id="hgroup">';
            } // end check for removed header image ?>

				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p id="site-description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>

            </div><!-- #hgroup -->
        </div><!-- #header-left -->

<?php
}
endif; // catcheverest_header_left

add_action( 'catcheverest_hgroup_wrap', 'catcheverest_header_left', 10 );


/**
 * Shows Header Right Sidebar
 */
function catcheverest_header_right() {

	/* A sidebar in the Header Right
	*/
	get_sidebar( 'header-right' );

}
add_action( 'catcheverest_hgroup_wrap', 'catcheverest_header_right', 15 );


/**
 * Shows header right content
 *
 * Shows the Primary Menu
 * @uses catcheverest_header action to add it in the header
 */
function catcheverest_header_menu() { ?>
	<div id="primary-menu-wrapper" class="menu-wrapper">
        <div class="menu-toggle-wrapper">
            <button id="menu-toggle" class="menu-toggle" aria-controls="main-menu" aria-expanded="false"><span class="menu-label"><?php esc_html_e( 'Menu', 'catch-everest' ); ?></span></button>
        </div><!-- .menu-toggle-wrapper -->

        <div class="menu-inside-wrapper">
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'catch-everest' ); ?>">
            <?php if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu(
                    array(
                        'container'      => '',
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'menu nav-menu',
                    )
                );
            } else {
                wp_page_menu(
                    array(
                        'menu_class' => 'primary-menu-container',
                        'before'     => '<ul id="menu-primary-items" class="menu nav-menu">',
                        'after'      => '</ul>',
                    )
                );
            }
            ?>
            </nav><!-- .main-navigation -->
    	</div>
    </div>
<?php
}
add_action( 'catcheverest_after_hgroup_wrap', 'catcheverest_header_menu', 10 );


/**
 * Function to pass the slider effectr parameters from php file to js file.
 */
function catcheverest_pass_slider_value() {
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

	$transition_effect   = $options['transition_effect'];
	$transition_delay    = $options['transition_delay'] * 1000;
	$transition_duration = $options['transition_duration'] * 1000;
	wp_localize_script(
		'catcheverest-slider',
		'js_value',
		array(
			array(
				'transition_effect'   => $transition_effect,
				'transition_delay'    => $transition_delay,
				'transition_duration' => $transition_duration,
			)
		)
	);
}// catcheverest_pass_slider_value


if ( ! function_exists( 'catcheverest_post_sliders' ) ) :
	/**
	 * Shows Featured Post Slider
	 *
	 * @uses catcheverest_header action to add it in the header
	 */
	function catcheverest_post_sliders() {
		//delete_transient( 'catcheverest_post_sliders' );

		global $post, $catcheverest_options_settings;
	   	$options = $catcheverest_options_settings;


		if ( ( !$catcheverest_post_sliders = get_transient( 'catcheverest_post_sliders' ) ) && !empty( $options['featured_slider'] ) ) {
			echo '<!-- refreshing cache -->';

			$catcheverest_post_sliders = '
			<div id="main-slider" class="container">
	        	<section class="featured-slider">';
					$loop = new WP_Query( array(
						'posts_per_page' => $options['slider_qty'],
						'post__in'		 => $options['featured_slider'],
						'orderby' 		 => 'post__in',
						'ignore_sticky_posts' => 1 // ignore sticky posts
					));
					$i=0; while ( $loop->have_posts()) : $loop->the_post(); $i++;
						$title_attribute = the_title_attribute( 'echo=0' );
						$excerpt = get_the_excerpt();
						if ( $i == 1 ) { $classes = "post hentry slides displayblock"; } else { $classes = "post hentry slides displaynone"; }
						$catcheverest_post_sliders .= '
						<article class="'.$classes.'">
							<figure class="slider-image">
								<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">
									'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class'	=> 'pngfix' ) ).'
								</a>
							</figure>
							<div class="entry-container">
								<header class="entry-header">
									<h2 class="entry-title">
										<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">'.the_title( '<span>','</span>', false ).'</a>
									</h2>
								</header>';
								if ( $excerpt !='') {
									$catcheverest_post_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
								}
								$catcheverest_post_sliders .= '
							</div>
						</article><!-- .slides -->';
					endwhile; wp_reset_postdata();
					$catcheverest_post_sliders .= '
				</section>
	        	<div id="slider-nav">
	        		<a class="slide-previous">&lt;</a>
	        		<a class="slide-next">&gt;</a>
	        	</div>
	        	<div id="controllers"></div>
	  		</div><!-- #main-slider -->';

		set_transient( 'catcheverest_post_sliders', $catcheverest_post_sliders, 86940 );
		}
		echo $catcheverest_post_sliders;
	}
endif; // catcheverest_post_sliders


if ( ! function_exists( 'catcheverest_slider_display' ) ) :
	/**
	 * Shows Slider
	 */
	function catcheverest_slider_display() {
		global $post, $wp_query, $catcheverest_options_settings;
	   	$options = $catcheverest_options_settings;

		// get data value from theme options
		$enableslider = $options['enable_slider'];
		$featuredslider = $options['featured_slider'];

		// Front page displays in Reading Settings
		$page_on_front = get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		if ( ( 'enable-slider-allpage' == $enableslider ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'enable-slider-homepage' == $enableslider ) ) :


			// This function passes the value of slider effect to js file.
			if ( function_exists( 'catcheverest_pass_slider_value' ) ) {
				catcheverest_pass_slider_value();
			}

			// Select Slider.
			if ( ! empty( $featuredslider ) ) {
				catcheverest_post_sliders();
			}
		endif;
	}
endif; // catcheverest_slider_display

add_action( 'catcheverest_before_main', 'catcheverest_slider_display', 10 );


if ( ! function_exists( 'catcheverest_homepage_headline' ) ) :
	/**
	 * Shows Homepage Headline Message
	 *
	 * @uses catcheverest_before_main action to add it in the header
	 */
	function catcheverest_homepage_headline() {
		//delete_transient( 'catcheverest_homepage_headline' );

		global $post, $wp_query, $catcheverest_options_settings;
	   	$options = $catcheverest_options_settings;

		// Getting data from Theme Options
		$disable_headline = $options['disable_homepage_headline'];
		$disable_subheadline = $options['disable_homepage_subheadline'];
		$homepage_headline = $options['homepage_headline'];
		$homepage_subheadline = $options['homepage_subheadline'];

		// Front page displays in Reading Settings
		$page_on_front = get_option('page_on_front') ;
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();


		if ( ( empty( $disable_headline ) || empty( $disable_subheadline ) ) && ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) {

			if ( !$catcheverest_homepage_headline = get_transient( 'catcheverest_homepage_headline' ) ) {

				echo '<!-- refreshing cache -->';

				$catcheverest_homepage_headline = '<div id="homepage-message" class="container"><p>';

				if ( $disable_headline == "0" ) {
					$catcheverest_homepage_headline .= $homepage_headline;
				}
				if ( $disable_subheadline == "0" ) {
					$catcheverest_homepage_headline .= '<span>' . $homepage_subheadline . '</span>';
				}

				$catcheverest_homepage_headline .= '</p></div>';

				set_transient( 'catcheverest_homepage_headline', $catcheverest_homepage_headline, 86940 );
			}
			echo $catcheverest_homepage_headline;
		 }
	}
endif; // catcheverest_homepage_headline

add_action( 'catcheverest_before_main', 'catcheverest_homepage_headline', 10 );

if ( ! function_exists( 'catcheverest_homepage_featured_content' ) ) :
	/**
	 * Homepage Featured Content
	 *
	 * @uses catcheverest_before_main action to add it in the header
	 */
	function catcheverest_homepage_featured_content() {
		//delete_transient( 'catcheverest_homepage_featured_content' );

		// Getting data from Theme Options
		global $catcheverest_options_settings;
	   	$options = $catcheverest_options_settings;
		$disable_homepage_featured = $options['disable_homepage_featured'];
		$quantity                  = $options['homepage_featured_qty'];
		$headline                  = $options['homepage_featured_headline'];

		if ( $disable_homepage_featured == "0" ) {

			$output = '<section id="featured-post" class="layout-three">';

			if ( ! empty( $headline ) ) {
				$output .= '<h2 id="feature-heading" class="entry-title">' . wp_kses_post( $headline ) . '</h2>';
			}

			if ( ! empty( array_filter( $options['homepage_featured_image'] ) ) || !empty( array_filter( $options['homepage_featured_title'] ) ) || !empty( array_filter( $options['homepage_featured_content'] ) ) ) {


				$output .= '<div class="featued-content-wrap">';

				for ( $i = 1; $i <= $quantity; $i++ ) {
					if ( !empty ( $options['homepage_featured_base'][ $i ] ) ) {
						$target = '_blank';
					} else {
						$target = '_self';
					}

					//Adding in Classes for Display blok and none
					if ( $i % 3 == 1  || $i == 1 ) {
						$classes = "post hentry first";
					}
					else {
						$classes = "post hentry";
					}

					//Checking Link
					if ( !empty ( $options['homepage_featured_url'][ $i ] ) ) {
						$link = $options['homepage_featured_url'][ $i ];
					} else {
						$link = '#';
					}

					//Checking Title
					if ( !empty ( $options['homepage_featured_title'][ $i ] ) ) {
						$title = $options['homepage_featured_title'][ $i ];
					} else {
						$title = '';
					}

					if ( !empty ( $options['homepage_featured_title'][ $i ] ) || !empty ( $options['homepage_featured_content'][ $i ] ) || !empty ( $options['homepage_featured_image'][ $i ] ) ) {
						$output .= '
						<article class="'.$classes.'">';
							if ( !empty ( $options['homepage_featured_image'][ $i ] ) ) {
								$output .= '
								<figure class="featured-homepage-image">
									<a title="' . esc_attr( $title ) . '" href="' . esc_url( $link ) . '" target="' . $target . '">
										<img src="'.$options['homepage_featured_image'][ $i ].'" class="wp-post-image" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '">
									</a>
								</figure>';
							}
							if ( !empty ( $options['homepage_featured_title'][ $i ] ) || !empty ( $options['homepage_featured_content'][ $i ] ) ) {
								$output .= '
								<div class="entry-container">';

									if ( !empty ( $options['homepage_featured_title'][ $i ] ) ) {
										$output .= '
										<header class="entry-header">
											<h2 class="entry-title">
												<a href="' . esc_url( $link ) . '" title="' . esc_attr( $title ) . '" target="' . $target . '">' . $title . '</a>
											</h2>
										</header>';
									}
									if ( !empty ( $options['homepage_featured_content'][ $i ] ) ) {
										$output .= '
										<div class="entry-content">
											' . $options['homepage_featured_content'][ $i ] . '
										</div>';
									}
								$output .= '
								</div><!-- .entry-container -->';
							}
						$output .= '
						</article><!-- .slides -->';
					}
				}

				$output .= '</div><!-- .featued-content-wrap -->';
			} elseif ( ! empty( $options['homepage_featured_page'] ) ) {
				$output .= '<div class="featued-content-wrap">';

				$args = array(
					'posts_per_page'      => $quantity,
					'post_type'           => 'page',
					'ignore_sticky_posts' => 1, // ignore sticky posts.
					'post__in'            => $options['homepage_featured_page'],
					'orderby'             => 'post__in',
				);


				// The Query
				$query = new WP_Query( $args );

				if ( $query -> have_posts() ) :
					while ( $query -> have_posts() ) :
						$query->the_post();

						$output .= '
						<article class="post hentry">';
							if ( has_post_thumbnail() ) {
								$output .= '
								<figure class="featured-homepage-image">
									<a title="' . the_title_attribute( 'echo=0' ) . '" href="' . esc_url( get_the_permalink() ) . '">'
									. get_the_post_thumbnail( get_the_ID(), 'photo-journal-featured-content' ) .
									'</a>
								</figure>';
							}

							$output .= '
							<div class="entry-container">';

							$output .= the_title( '<header class="entry-header"><h2 class="entry-title"> <a href="' . esc_url( get_the_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h2></header>', false );

							$excerpt = get_the_excerpt();

							if ( $excerpt !='') {
								$output .= '<div class="entry-content">' . wp_kses_post( $excerpt ) . '</div>';
							}

							$output .= '
							</div><!-- .entry-container -->
						</article><!-- .hentry -->';
					endwhile;

					wp_reset_postdata();


				endif;

				$output .= '</div><!-- .featued-content-wrap -->';
			}

			$output .= '</section>';

			echo $output;
		}

	}
endif; // catcheverest_homepage_featured_content


/**
 * Homepage Featured Content
 *
 * @uses catcheverest_before_main action to add it in the header
 */
function catcheverest_homepage_featured_display() {
	if ( is_front_page() || ( is_home() && is_front_page() ) ) {
		catcheverest_homepage_featured_content();
	}
} // catcheverest_homepage_featured_content

add_action( 'catcheverest_main', 'catcheverest_homepage_featured_display', 10 );


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function catcheverest_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


/**
 * Function for footer content
 */
function catcheverest_footer_content() {
	//delete_transient( 'catcheverest_footer_content_new' );

	if ( ( !$catcheverest_footer_content = get_transient( 'catcheverest_footer_content_new' ) ) ) {
		echo '<!-- refreshing cache -->';

		$catcheverest_footer_content = catcheverest_assets();

    	set_transient( 'catcheverest_footer_content_new', $catcheverest_footer_content, 86940 );
    }
	echo $catcheverest_footer_content;
}
add_action( 'catcheverest_site_generator', 'catcheverest_footer_content', 10 );


/**
 * Alter the query for the main loop in homepage
 * @uses pre_get_posts hook
 */
function catcheverest_alter_home( $query ){
	if ( $query->is_main_query() && $query->is_home() ) {
		global $catcheverest_options_settings;
	   	$options = $catcheverest_options_settings;

	    $cats = $options['front_page_category'];

	    if ( $options[ 'exclude_slider_post'] != "0" && !empty( $options['featured_slider'] ) ) {
			$query->query_vars['post__not_in'] = $options['featured_slider'];
		}
		if ( is_array( $cats ) && !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts','catcheverest_alter_home' );


if ( ! function_exists( 'catcheverest_social_networks' ) ) :
/**
 * This function for Social Icons
 *
 * @fetch links through Theme Options
 * @use in widget
 * @social links, Facebook, Twitter and RSS
  */
function catcheverest_social_networks() {
	//delete_transient( 'catcheverest_social_networks' );

	// get the data value from theme options
	global $catcheverest_options_settings;
   	$options = $catcheverest_options_settings;

    $elements = array();

	$elements = array( 	$options['social_facebook'],
						$options['social_twitter'],
						$options['social_googleplus'],
						$options['social_linkedin'],
						$options['social_pinterest'],
						$options['social_youtube'],
						$options['social_vimeo'],
						$options['social_slideshare'],
						$options['social_foursquare'],
						$options['social_flickr'],
						$options['social_tumblr'],
						$options['social_deviantart'],
						$options['social_dribbble'],
						$options['social_myspace'],
						$options['social_wordpress'],
						$options['social_rss'],
						$options['social_delicious'],
						$options['social_lastfm'],
						$options['social_instagram'],
						$options['social_github'],
						$options['social_vkontakte'],
						$options['social_myworld'],
						$options['social_odnoklassniki'],
						$options['social_goodreads'],
						$options['social_skype'],
						$options['social_soundcloud'],
						$options['social_email'],
						$options['social_contact'],
						$options['social_xing']
					);
	$flag = 0;
	if ( !empty( $elements ) ) {
		foreach( $elements as $option) {
			if ( !empty( $option ) ) {
				$flag = 1;
			}
			else {
				$flag = 0;
			}
			if ( $flag == 1 ) {
				break;
			}
		}
	}

	if ( ( !$catcheverest_social_networks = get_transient( 'catcheverest_social_networks' ) ) && ( $flag == 1 ) )  {
		echo '<!-- refreshing cache -->';

		$catcheverest_social_networks .='
		<ul class="social-profile">';

			//facebook
			if ( !empty( $options['social_facebook'] ) ) {
				$catcheverest_social_networks .=
					'<li class="facebook"><a href="'.esc_url( $options['social_facebook'] ).'" title="'. esc_attr__( 'Facebook', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Facebook', 'catch-everest' ) .'</a></li>';
			}
			//Twitter
			if ( !empty( $options['social_twitter'] ) ) {
				$catcheverest_social_networks .=
					'<li class="twitter"><a href="'.esc_url( $options['social_twitter'] ).'" title="'. esc_attr__( 'Twitter', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Twitter', 'catch-everest' ) .'</a></li>';
			}
			//Google+
			if ( !empty( $options['social_googleplus'] ) ) {
				$catcheverest_social_networks .=
					'<li class="google-plus"><a href="'.esc_url( $options['social_googleplus'] ).'" title="'. esc_attr__( 'Google+', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Google+', 'catch-everest' ) .'</a></li>';
			}
			//Linkedin
			if ( !empty( $options['social_linkedin'] ) ) {
				$catcheverest_social_networks .=
					'<li class="linkedin"><a href="'.esc_url( $options['social_linkedin'] ).'" title="'. esc_attr__( 'LinkedIn', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'LinkedIn', 'catch-everest' ) .'</a></li>';
			}
			//Pinterest
			if ( !empty( $options['social_pinterest'] ) ) {
				$catcheverest_social_networks .=
					'<li class="pinterest"><a href="'.esc_url( $options['social_pinterest'] ).'" title="'. esc_attr__( 'Pinterest', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Pinterest', 'catch-everest' ) .'</a></li>';
			}
			//Youtube
			if ( !empty( $options['social_youtube'] ) ) {
				$catcheverest_social_networks .=
					'<li class="you-tube"><a href="'.esc_url( $options['social_youtube'] ).'" title="'. esc_attr__( 'YouTube', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'YouTube', 'catch-everest' ) .'</a></li>';
			}
			//Vimeo
			if ( !empty( $options['social_vimeo'] ) ) {
				$catcheverest_social_networks .=
					'<li class="viemo"><a href="'.esc_url( $options['social_vimeo'] ).'" title="'. esc_attr__( 'Vimeo', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Vimeo', 'catch-everest' ) .'</a></li>';
			}
			//Slideshare
			if ( !empty( $options['social_slideshare'] ) ) {
				$catcheverest_social_networks .=
					'<li class="slideshare"><a href="'.esc_url( $options['social_slideshare'] ).'" title="'. esc_attr__( 'SlideShare', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'SlideShare', 'catch-everest' ) .'</a></li>';
			}
			//Foursquare
			if ( !empty( $options['social_foursquare'] ) ) {
				$catcheverest_social_networks .=
					'<li class="foursquare"><a href="'.esc_url( $options['social_foursquare'] ).'" title="'. esc_attr__( 'FourSquare', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'FourSquare', 'catch-everest' ) .'</a></li>';
			}
			//Flickr
			if ( !empty( $options['social_flickr'] ) ) {
				$catcheverest_social_networks .=
					'<li class="flickr"><a href="'.esc_url( $options['social_flickr'] ).'" title="'. esc_attr__( 'Flickr', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Flickr', 'catch-everest' ) .'</a></li>';
			}
			//Tumblr
			if ( !empty( $options['social_tumblr'] ) ) {
				$catcheverest_social_networks .=
					'<li class="tumblr"><a href="'.esc_url( $options['social_tumblr'] ).'" title="'. esc_attr__( 'Tumblr', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Tumblr', 'catch-everest' ) .'</a></li>';
			}
			//deviantART
			if ( !empty( $options['social_deviantart'] ) ) {
				$catcheverest_social_networks .=
					'<li class="deviantart"><a href="'.esc_url( $options['social_deviantart'] ).'" title="'. esc_attr__( 'deviantART', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'deviantART', 'catch-everest' ) .'</a></li>';
			}
			//Dribbble
			if ( !empty( $options['social_dribbble'] ) ) {
				$catcheverest_social_networks .=
					'<li class="dribbble"><a href="'.esc_url( $options['social_dribbble'] ).'" title="'. esc_attr__( 'Dribbble', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Dribbble', 'catch-everest' ) .'</a></li>';
			}
			//MySpace
			if ( !empty( $options['social_myspace'] ) ) {
				$catcheverest_social_networks .=
					'<li class="myspace"><a href="'.esc_url( $options['social_myspace'] ).'" title="'. esc_attr__( 'MySpace', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'MySpace', 'catch-everest' ) .'</a></li>';
			}
			//WordPress
			if ( !empty( $options['social_wordpress'] ) ) {
				$catcheverest_social_networks .=
					'<li class="wordpress"><a href="'.esc_url( $options['social_wordpress'] ).'" title="'. esc_attr__( 'WordPress', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'WordPress', 'catch-everest' ) .'</a></li>';
			}
			//RSS
			if ( !empty( $options['social_rss'] ) ) {
				$catcheverest_social_networks .=
					'<li class="rss"><a href="'.esc_url( $options['social_rss'] ).'" title="'. esc_attr__( 'RSS', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'RSS', 'catch-everest' ) .'</a></li>';
			}
			//Delicious
			if ( !empty( $options['social_delicious'] ) ) {
				$catcheverest_social_networks .=
					'<li class="delicious"><a href="'.esc_url( $options['social_delicious'] ).'" title="'. esc_attr__( 'Delicious', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Delicious', 'catch-everest' ) .'</a></li>';
			}
			//Last.fm
			if ( !empty( $options['social_lastfm'] ) ) {
				$catcheverest_social_networks .=
					'<li class="lastfm"><a href="'.esc_url( $options['social_lastfm'] ).'" title="'. esc_attr__( 'Last.fm', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Last.fm', 'catch-everest' ) .'</a></li>';
			}
			//Instagram
			if ( !empty( $options['social_instagram'] ) ) {
				$catcheverest_social_networks .=
					'<li class="instagram"><a href="'.esc_url( $options['social_instagram'] ).'" title="'. esc_attr__( 'Instagram', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Instagram', 'catch-everest' ) .'</a></li>';
			}
			//GitHub
			if ( !empty( $options['social_github'] ) ) {
				$catcheverest_social_networks .=
					'<li class="github"><a href="'.esc_url( $options['social_github'] ).'" title="'. esc_attr__( 'GitHub', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'GitHub', 'catch-everest' ) .'</a></li>';
			}
			//Vkontakte
			if ( !empty( $options['social_vkontakte'] ) ) {
				$catcheverest_social_networks .=
					'<li class="vkontakte"><a href="'.esc_url( $options['social_vkontakte'] ).'" title="'. esc_attr__( 'Vkontakte', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Vkontakte', 'catch-everest' ) .'</a></li>';
			}
			//My World
			if ( !empty( $options['social_myworld'] ) ) {
				$catcheverest_social_networks .=
					'<li class="myworld"><a href="'.esc_url( $options['social_myworld'] ).'" title="'. esc_attr__( 'My World', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'My World', 'catch-everest' ) .'</a></li>';
			}
			//Odnoklassniki
			if ( !empty( $options['social_odnoklassniki'] ) ) {
				$catcheverest_social_networks .=
					'<li class="odnoklassniki"><a href="'.esc_url( $options['social_odnoklassniki'] ).'" title="'. esc_attr__( 'Odnoklassniki', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Odnoklassniki', 'catch-everest' ) .'</a></li>';
			}
			//Goodreads
			if ( !empty( $options['social_goodreads'] ) ) {
				$catcheverest_social_networks .=
					'<li class="goodreads"><a href="'.esc_url( $options['social_goodreads'] ).'" title="'. esc_attr__( 'GoodReads', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'GoodReads', 'catch-everest' ) .'</a></li>';
			}
			//Skype
			if ( !empty( $options['social_skype'] ) ) {
				$catcheverest_social_networks .=
					'<li class="skype"><a href="'.esc_attr( $options['social_skype'] ).'" title="'. esc_attr__( 'Skype', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Skype', 'catch-everest' ) .'</a></li>';
			}
			//Soundcloud
			if ( !empty( $options['social_soundcloud'] ) ) {
				$catcheverest_social_networks .=
					'<li class="soundcloud"><a href="'.esc_url( $options['social_soundcloud'] ).'" title="'. esc_attr__( 'SoundCloud', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'SoundCloud', 'catch-everest' ) .'</a></li>';
			}
			//Email
			if ( !empty( $options['social_email'] ) ) {
				$catcheverest_social_networks .=
					'<li class="email"><a href="mailto:'.sanitize_email( $options['social_email'] ).'" title="'. esc_attr__( 'Email', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Email', 'catch-everest' ) .'</a></li>';
			}
			//Contact
			if ( !empty( $options['social_contact'] ) ) {
				$catcheverest_social_networks .=
					'<li class="contactus"><a href="'.esc_url( $options['social_contact'] ).'" title="'. esc_attr__( 'Contact', 'catch-everest' ) .'">'. esc_attr__( 'Contact', 'catch-everest' ) .'</a></li>';
			}
			//Xing
			if ( !empty( $options['social_xing'] ) ) {
				$catcheverest_social_networks .=
					'<li class="xing"><a href="'.esc_url( $options['social_xing'] ).'" title="'. esc_attr__( 'Xing', 'catch-everest' ) .'" target="_blank">'. esc_attr__( 'Xing', 'catch-everest' ) .'</a></li>';
			}

			$catcheverest_social_networks .='
		</ul>';

		set_transient( 'catcheverest_social_networks', $catcheverest_social_networks, 86940 );
	}
	echo $catcheverest_social_networks;
}
endif; // catcheverest_social_networks


/**
 * Site Verification and Header Code from the Theme Option
 *
 * If user sets the code we're going to display meta verification
 * @get the data value from theme options
 * @uses wp_head action to add the code in the header
 * @uses set_transient and delete_transient API for cache
 */
function catcheverest_webmaster() {
	//delete_transient( 'catcheverest_webmaster' );

	if ( ( !$catcheverest_webmaster = get_transient( 'catcheverest_webmaster' ) ) ) {

		// get the data value from theme options
		global $catcheverest_options_settings;
   		$options = $catcheverest_options_settings;
		echo '<!-- refreshing cache -->';

		$catcheverest_webmaster = '';
		//google
		if ( !empty( $options['google_verification'] ) ) {
			$catcheverest_webmaster .= '<meta name="google-site-verification" content="' .  $options['google_verification'] . '" />' . "\n";
		}
		//bing
		if ( !empty( $options['bing_verification'] ) ) {
			$catcheverest_webmaster .= '<meta name="msvalidate.01" content="' .  $options['bing_verification']  . '" />' . "\n";
		}
		//yahoo
		 if ( !empty( $options['yahoo_verification'] ) ) {
			$catcheverest_webmaster .= '<meta name="y_key" content="' .  $options['yahoo_verification']  . '" />' . "\n";
		}
		//site stats, analytics header code
		if ( !empty( $options['analytic_header'] ) ) {
			$catcheverest_webmaster =  $options['analytic_header'] ;
		}

		set_transient( 'catcheverest_webmaster', $catcheverest_webmaster, 86940 );
	}
	echo $catcheverest_webmaster;
}
add_action('wp_head', 'catcheverest_webmaster');


/**
 * This function loads the Footer Code such as Add this code from the Theme Option
 *
 * @get the data value from theme options
 * @load on the footer ONLY
 * @uses wp_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function catcheverest_footercode() {
	//delete_transient( 'catcheverest_footercode' );

	if ( ( !$catcheverest_footercode = get_transient( 'catcheverest_footercode' ) ) ) {

		// get the data value from theme options
		global $catcheverest_options_settings;
   		$options = $catcheverest_options_settings;
		echo '<!-- refreshing cache -->';

		//site stats, analytics header code
		if ( !empty( $options['analytic_footer'] ) ) {
			$catcheverest_footercode =  $options['analytic_footer'] ;
		}

		set_transient( 'catcheverest_footercode', $catcheverest_footercode, 86940 );
	}
	echo $catcheverest_footercode;
}
add_action('wp_footer', 'catcheverest_footercode');


/**
 * Adds in post ID when viewing lists of posts
 * This will help the admin to add the post ID in featured slider
 *
 * @param mixed $post_columns
 * @return post columns
 */
function catcheverest_post_id_column( $post_columns ) {
	$beginning = array_slice( $post_columns, 0 ,1 );
	$beginning[ 'postid' ] = __( 'ID', 'catch-everest'  );
	$ending = array_slice( $post_columns, 1 );
	$post_columns = array_merge( $beginning, $ending );
	return $post_columns;
}

add_filter( 'manage_posts_columns', 'catcheverest_post_id_column' );

function catcheverest_posts_id_column( $col, $val ) {
	if ( 'postid' == $col ) echo $val;
}

add_action( 'manage_posts_custom_column', 'catcheverest_posts_id_column', 10, 2 );

function catcheverest_posts_id_column_css() {
	echo '
	<style type="text/css">
	    #postid { width: 80px; }
	    @media screen and (max-width: 782px) {
	        .wp-list-table #postid, .wp-list-table #the-list .postid { display: none; }
	        .wp-list-table #the-list .is-expanded .postid {
	            padding-left: 30px;
	        }
	    }
    </style>';
}

add_action( 'admin_head-edit.php', 'catcheverest_posts_id_column_css' );


if ( ! function_exists( 'catcheverest_menu_alter' ) ) :
/**
* Add default navigation menu to nav menu
* Used while viewing on smaller screen
*/
function catcheverest_menu_alter( $items, $args ) {
	$items .= '<li class="default-menu"><a href="' . esc_url( home_url( '/' ) ) . '" title="Menu">'.__( 'Menu', 'catch-everest' ).'</a></li>';
	return $items;
}
endif; // catcheverest_menu_alter

add_filter( 'wp_nav_menu_items', 'catcheverest_menu_alter', 10, 2 );


if ( ! function_exists( 'catcheverest_pagemenu_alter' ) ) :
/**
 * Add default navigation menu to page menu
 * Used while viewing on smaller screen
 */
function catcheverest_pagemenu_alter( $output ) {
	$output .= '<li class="default-menu"><a href="' . esc_url( home_url( '/' ) ) . '" title="Menu">'.__( 'Menu', 'catch-everest' ).'</a></li>';
	return $output;
}
endif; // catcheverest_pagemenu_alter

add_filter( 'wp_list_pages', 'catcheverest_pagemenu_alter' );


if ( ! function_exists( 'catcheverest_pagemenu_filter' ) ) :
/**
 * @uses wp_page_menu filter hook
 */
function catcheverest_pagemenu_filter( $text ) {
	$replace = array(
		'current_page_item'     => 'current-menu-item'
	);

	$text = str_replace(array_keys($replace), $replace, $text);
  	return $text;

}
endif; // catcheverest_pagemenu_filter

add_filter('wp_page_menu', 'catcheverest_pagemenu_filter');


/**
 * This function loads Scroll Up Navigation
 *
 * @get the data value from theme options for disable
 * @uses catcheverest_after_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function catcheverest_scrollup() {
	//delete_transient( 'catcheverest_scrollup' );

	if ( !$catcheverest_scrollup = get_transient( 'catcheverest_scrollup' ) ) {

		// get the data value from theme options
		global $catcheverest_options_settings;
   		$options = $catcheverest_options_settings;
		echo '<!-- refreshing cache -->';

		//site stats, analytics header code
		if ( empty( $options['disable_scrollup'] ) ) {
			$catcheverest_scrollup =  '<a href="#masthead" id="scrollup"></a>' ;
		}

		set_transient( 'catcheverest_scrollup', $catcheverest_scrollup, 86940 );
	}
	echo $catcheverest_scrollup;
}
add_action( 'catcheverest_after_footer', 'catcheverest_scrollup', 10 );
