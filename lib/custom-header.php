<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 *
*/

// Custom Header Options
// $header_options = array(
// 	'railroad' 		=> array(
// 		'url' 			=> '%s/img/headers/railroad.jpg',
// 		'thumbnail_url'	=> '%s/img/headers/railroad-thumbnail.jpg',
// 		'description' 	=> __('Railroad Beach'),
// 	),
// 	'treedlane' 	=> array(
// 		'url' 			=> '%s/img/headers/treed-lane.jpg',
// 		'thumbnail_url'	=> '%s/img/headers/treed-lane-thumbnail.jpg',
// 		'description' 	=> __('Treed Lane'),
// 	),
// 	'skyrose' 		=> array(
// 		'url' 			=> '%s/img/headers/sky-rose.jpg',
// 		'thumbnail_url'	=> '%s/img/headers/sky-rose-thumbnail.jpg',
// 		'description' 	=> __('Roses in the Sky'),
// 	),
// 	'sunrisefield' 	=> array(
// 		'url' 			=> '%s/img/headers/sunrise-field.jpg',
// 		'thumbnail_url'	=> '%s/img/headers/sunrise-field-thumbnail.jpg',
// 		'description' 	=> __('Sunrise over a Field'),
// 	),
// 	'hiker' 	=> array(
// 		'url' 			=> '%s/img/headers/hiker.jpg',
// 		'thumbnail_url'	=> '%s/img/headers/hiker-thumbnail.jpg',
// 		'description' 	=> __("Hiker's Triumph"),
// 	),
// );
// register_default_headers($header_options);

function readium_custom_header_setup() {
	add_theme_support('custom-header',
		apply_filters('readium_custom_header_args',
			array(
				'default-image'	=> '%s/img/headers/railroad.jpg',
				'default-text-color'	=> 'ffffff',
				'width'					=> 1600,
				'height'				=> 700,
				'flex-height' 			=> true,
				'flex-width'			=> false,
				'wp-head-callback'       => 'readium_header_style',
			)
		)
	);
}
add_action('after_setup_theme', 'readium_custom_header_setup');

if ( ! function_exists( 'readium_header_style' ) ) :

function readium_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		#page-header-text {
			color:#<?php echo get_header_textcolor(); ?>;
		}
	</style>
	<?php
}
endif; // readium_header_style

if ( ! function_exists( 'readium_custom_header_image' ) ) :
/**
 * Header image styles for custom header and featured images
 *
 */
function readium_custom_header_image() {

	$processed = array();
	
	// get the header image; this is the default.
	$header_image = get_custom_header();

	if ($header_image != '') {
		
		$processed['url'] = $header_image->url;
		$processed['width'] = $header_image->width;
		$processed['height'] = $header_image->height;

	}
	
	if (is_singular()) {

		if (get_the_post_thumbnail() != '') {

			// get the URL of the featured image
			$header_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'page-header');
			$processed['url'] = $header_image[0];
			$processed['width'] = $header_image[1];
			$processed['height'] = $header_image[2];
		}

	}

	// if $header_image is an empty string, set it to false.
	$processed = (empty($processed)) ? false : $processed;

	return $processed;

}
endif; // readium_custom_header_image

add_action('wp_head', 'readium_custom_header_image');