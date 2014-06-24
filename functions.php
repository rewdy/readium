<?php /*

Readium Theme
-------------

functions.php

Functions file	

*/

/**
 * Initiating settings
 */

// Add automatic feed links
add_theme_support('automatic-feed-links');

// Enable post thumbnails
add_theme_support('post-thumbnails');

// Add some image sizes for post thumbnails
add_image_size('resource-thumb', 340, 800);
add_image_size('page-header', 1600, 700, true);

// Add menus
if (function_exists('register_nav_menu')) {
	register_nav_menu('primary', 'Main Menu');
	register_nav_menu('footer', 'Footer Menu');
}

// Content width
if (!isset($content_width)) {
	$content_width = 864;
}

/**
 * Setup Widget Areas
 */
function readium_widget_init() {
	// Register drawer widgets
	register_sidebar(
		array(
			'name' => __('Drawer'),
			'desc' => __('Place widgets in the "drawer" below the slide out menu.'),
			'id' => 'drawer-widgets',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		)
	);
	
	// Register footer widgets
	register_sidebar(
		array(
			'name' => __('Footer'),
			'desc' => __('Place widgets in the site footer. These look best in multiples of two (2, 4, etc).'),
			'id' => 'footer-widgets',
			'before_widget' => '<div id="%1$s" class="g6 widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2><div class="lined">'
		)
	);
}
add_action('widgets_init', 'readium_widget_init');

/**
 * Custom Post Types
 */
function create_post_type() {
	// set labels
	$labels = array(
		'name'				=> __('Resources'),
		'singular_name'		=> __('Resource'),
		'menu_name'			=> __('Resource'),
		'parent_item_colon' => __('Parent Resource:'),
		'all_items'			=> __('All Resources'),
		'view_item'			=> __('View Resource'),
		'add_new_item'		=> __('Add New Resource'),
		'add_new'			=> __('New Resource'),
		'edit_item'			=> __('Edit Resource'),
		'update_item'		=> __('Update Resource'),
		'search_items'		=> __('Search resources'),
		'not_found'			=> __('No resources found'),
		'not_found_in_trash'=> __('No resources found in Trash'),
	);

	// setup args
	$args = array(
		'labels' 			=> $labels,
		'supports' 			=> array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
		'menu_position' 	=> 5,
		'public' 			=> true,
		'has_archive' 		=> true,
		'rewrite' 			=> array('slug' => 'resources'),
	);

	// make the post type
	register_post_type('readium_resource', $args);
}
add_action('init', 'create_post_type');

// Set the limit for resources archive
function readium_query_mod($query) {
	if ($query->is_post_type_archive('readium_resource') && !is_admin()) {
		$query->set('posts_per_page', 9);
		return;
	}
}
add_action('pre_get_posts','readium_query_mod');


/**
 * Custom Header Stuff
 */

// Custom Header Image
function readium_custom_header_setup() {
	$header_args = array(
		'default-image'			=> '%s/img/headers/perfect-vacation.jpg',
		'default-text-color'	=> 'ffffff',
		'width'					=> 1600,
		'height'				=> 700,
		'flex-height' 			=> true,
		'flex-width'			=> false,
		'uploads'				=> true,
		'wp-head-callback'      => 'readium_header_style',
	);
	add_theme_support('custom-header', $header_args);
}
add_action('after_setup_theme', 'readium_custom_header_setup');

// Custom Header Options
$header_options = array(
	'vacation' 		=> array(
		'url' 			=> '%s/img/headers/perfect-vacation.jpg',
		'thumbnail_url'	=> '%s/img/headers/perfect-vacation-thumbnail.jpg',
		'description' 	=> __('Perfect Vacation'),
	),
	'coffee' 	=> array(
		'url' 			=> '%s/img/headers/blue-bottle-coffee.jpg',
		'thumbnail_url'	=> '%s/img/headers/blue-bottle-coffee-thumbnail.jpg',
		'description' 	=> __('Blue Bottle Coffee'),
	),
	'sky' 	=> array(
		'url' 			=> '%s/img/headers/big-sky.jpg',
		'thumbnail_url'	=> '%s/img/headers/big-sky-thumbnail.jpg',
		'description' 	=> __('Big Sky'),
	),
);
register_default_headers($header_options);

if (!function_exists('readium_header_style')) :
function readium_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>

	<style type="text/css">
		header#site-header #page-title {
			color:#<?php echo get_header_textcolor(); ?>;
		}
	</style>

	<?php
}
endif; // readium_header_style


/**
 * wp_customize settings
 */
class Readium_Customize {
	public static function register($wp_customize) {
		// add the sections
		$wp_customize->add_section('readium_resources_header_image_section',
			array(
				'title'			=> __('Resources Header Image', 'readium'),
				'priority'		=> 65,
				'capability'	=> 'edit_theme_options',
				'description' 	=> __('Upload a header image to be shown on the resources section of the site <b style="color:#c00">(Please resize to 1600x840ish before uploading)</b>:', 'readium')
			)
		);
		$wp_customize->add_section('readium_header_options_section',
			array(
				'title'			=> __('Readium Header Style', 'readium'),
				'priority'		=> 55,
				'capability'	=> 'edit_theme_options',
				'description' 	=> __('How would you like the site title to be displayed?', 'readium')
			)
		);

		// add the settings
		$wp_customize->add_setting('resources_header_image',
			array(
				'default' 	=> '%s/img/headers/perfect-vacation.jpg',
				'type'		=> 'theme_mod',
				'capability'=> 'edit_theme_options',
				'transport'	=> 'refresh',
			)
		);
		$wp_customize->add_setting('readium_header_style',
			array(
				'default' 	=> 'bar',
				'type'		=> 'option',
				'capability'=> 'edit_theme_options',
				'transport'	=> 'refresh',
			)
		);
		$wp_customize->add_setting('readium_header_show_tagline',
			array(
				'default' 	=> 0,
				'type'		=> 'option',
				'capability'=> 'edit_theme_options',
				'transport'	=> 'refresh',
			)
		);

		// add the controls for the settings
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'resources_header_image',
				array(
					'label' 	=> __('Resources Header Image', 'readium'),
					'section'	=> 'readium_resources_header_image_section',
					'settings'	=> 'resources_header_image'
				)
			)
		);
		$wp_customize->add_control('readium_header_style',
			array(
				'label'   => 'Select the header style',
				'section' => 'readium_header_options_section',
				'type'    => 'select',
				'choices'    => array(
					'bar' => 'Title in header bar',
					'over_image' => 'Title over header image',
				),
			) 
		);
		$wp_customize->add_control('readium_header_show_tagline',
			array(
				'label'   => 'Show the tagline? (Applies only when title is shown over the header image)',
				'section' => 'readium_header_options_section',
				'type'    => 'select',
				'choices'    => array(
					0 => 'Do not show the tagline',
					1 => 'Show the tagline',
				),
			) 
		);
	}
}

add_action('customize_register', array('Readium_Customize', 'register'));

if (!function_exists('readium_custom_header_image')) :
// custom header image function
function readium_custom_header_image() {

	$processed = array();
	
	// get the header image; this is the default.
	$header_image = get_custom_header();

	if ($header_image != '') {
		$processed['url'] = $header_image->url;
		$processed['width'] = $header_image->width;
		$processed['height'] = $header_image->height;
	}
	
	// check for redium_resource pages, otherwise check for (other) singular pages
	if (is_post_type_archive('readium_resource') || is_singular('readium_resource')) {
		// set header_image to the resources image
		$resources_image = get_theme_mod('resources_header_image');
		if ($resources_image != '') {
			$header_image = $resources_image;
			$processed['url'] = $header_image;
			$processed['width'] = '';
			$processed['height'] = '';
		}

	} else if (is_singular()) {

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


/**
 * Comment mods because the defaults here suck
 */

// Custom comment output
function readium_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		$args['avatar_size'] = 32;
		$args['reply_text'] = '<i class="fa fa-comments-o"></i><span class="text">'.__('Reply').'</span>';
?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?>>

			<article class="comment">

				<?php if ($comment->comment_approved == '0') : ?>
				<p class="comment-awaiting-moderation box-help"><?php _e('Your comment is awaiting moderation.') ?></p>
				<?php endif; ?>

				<?php comment_text() ?>

				<div class="links">
					<ul class="link-list">
						<li><?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></li>
						<li><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>" title="Permalink"><i class="fa fa-link"></i><span class="text">
							Comment permalink</span></a></li>
						<?php edit_comment_link('<i class="fa fa-pencil"></i><span class="text">Edit</span>','<li>','</li>'); ?>
					</ul>
				</div>
				<div class="details">
					<span class="avatar"><?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?></span>
					<span class="comment-author vcard"><?php printf(__('<span class="says">Posted by</span> <cite class="fn">%s</cite>'), get_comment_author_link()) ?></span> &bullet; 
					<span class="comment-date"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?></a></span>
				</div>

			</article>
		</li>
<?php
}

/**
 * The default Wordpress comment form
 * leaves a lot to be desired. Here is
 * a version that has more markup and is
 * easier to style.
 */
function readium_comment_form() {
	// define fields
	$fields = array(
		'author' => '<p class="form-item label-inline comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<span class="input-holder"><input id="author" name="author" type="text" class="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></span></p>',
		'email'  => '<p class="form-item label-inline comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<span class="input-holder"><input id="email" name="email" type="text" class="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></span></p>',
		'url'	=> '<p class="form-item label-inline comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		'<span class="input-holder"><input id="url" name="url" type="text" class="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></p>',
	);
	
	// build our new defaults array (based off of default defaults. customized values noted.
	$defaults = array(
		'fields'			=> apply_filters('comment_form_default_fields', $fields ), /* customized */
		'comment_field'		=> '<p class="form-item comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><span class="input-holder"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></span></p>', /* customized */
		'must_log_in'			=> '<p class="must-log-in help">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'			=> '<p class="logged-in-as help">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before'	=> '<p class="comment-notes help">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'	=> '<p class="some-html-allowed help small">' . sprintf(__('Some <abbr title="Hyper Text Markup Language">HTML</abbr> allowed: <code>%s</code>'), allowed_tags()) . '</p>', /* customized */
		'id_form'				=> 'commentform',
		'id_submit'				=> 'submit',
		'title_reply'			=> __( 'Leave a Comment' ),
		'title_reply_to'		=> __( 'Leave a Reply to %s' ),
		'cancel_reply_link'		=> __( 'Cancel Comment' ),
		'label_submit'			=> __( 'Post Comment' )
	);
	
	// send them back out! Bam!
	return $defaults;
}
add_filter('comment_form_defaults', 'readium_comment_form');

/**
 * Functions available in templates
*/

// adding fuction to get the author posts link (the only built-in function echos it).
if (!function_exists('get_author_posts_link')) {
	// must be called from within the loop
	function get_author_posts_link() {
		$the_author = get_the_author();
		$author_url = get_author_posts_url(get_the_author_meta('ID'));
		return '<a href="' . $author_url . '">' . $the_author . '</a>';
	}
}

function readium_get_header_style() {
	return get_option('readium_header_style');
}

function readium_show_tagline() {
	return get_option('readium_header_show_tagline');
}

// Function(s) to generate a list of links for sharing
function get_share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	if (isset($url) && isset($title)) {
		$url = urlencode($url);
		$title = urlencode($title);

		$services['facebook'] = array(
			'label' => 'Facebook',
			'url'	=> 'http://www.facebook.com/sharer.php?s=100&amp;p[title]={{title}}&amp;p[url]={{url}}',
			'icon'	=> 'facebook',
		);
		$services['twitter'] = array(
			'label' => 'Twitter',
			'url'	=> 'https://twitter.com/intent/tweet?url={{url}}&amp;text={{title}}',
			'icon'	=> 'twitter',
		);
		$services['pinterest'] = array(
			'label'	=> 'Pinterest',
			'url'	=> 'http://www.pinterest.com/pin/create/bookmarklet/?url={{url}}&description={{title}}',
			'icon'	=> 'pinterest',
		);
		$services['tumblr'] = array(
			'label'	=> 'Tumblr',
			'url'	=> 'http://www.tumblr.com/share/?url={{url}}&description={{title}}',
			'icon'	=> 'tumblr',
		);
		$services['gplus'] = array(
			'label'	=> 'Google +',
			'url'	=> 'https://plus.google.com/share?url={{url}}',
			'icon'	=> 'google-plus',
		);
		$services['email']	= array(
			'label'	=> 'Email',
			'url'	=> 'mailto:?&amp;Subject={{title}}&amp;Body={{url}}',
			'icon'	=> 'envelope',
		);

		// build the output
		$output = '<ul class="' . $class . '">' . "\n";
		foreach ($services as $key => $service) {
			$extra = (isset($service['extra'])) ? ' '.$service['extra'] : '';
			$output .= "\t" . '<li><a href="'.$service[url].'" class="'.$key.'"'.$extra.'><i class="{{icon_prefix}}'.$service[icon].'"></i> <span class="text">'.$service[label].'</span></a></li>' . "\n";
		}
		$output .= '</ul>';

		$output = preg_replace('/{{url}}/', $url, $output);
		$output = preg_replace('/{{title}}/', $title, $output);
		$output = preg_replace('/{{icon_prefix}}/', $icon_prefix, $output);

		return $output;
	} else {
		// not enought data. return empty string.
		return '';
	}
}
function share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	echo get_share_links($url, $title, $class, $icon_prefix);
}