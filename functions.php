<?php /*

Readium Theme
-------------

functions.php

Functions file	

*/

// Add menus
if (function_exists('register_nav_menu')) {
	register_nav_menu('primary', 'Main Menu');
	register_nav_menu('footer', 'Footer Menu');
}

// Add widget areas
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

// Custom Header Image
$header_args = array(
	'default-image'	=> '%s/img/headers/railroad.jpg',
	'width'			=> 2000,
	'height'		=> 800,
	'flex-height' 	=> true,
	'flex-width'	=> false,
	'uploads'		=> true,
);
add_theme_support('custom-header', $header_args);

// Custom Header Options
$header_options = array(
	'railroad' 		=> array(
		'url' 			=> '%s/img/headers/railroad.jpg',
		'thumbnail_url'	=> '%s/img/headers/railroad-thumbnail.jpg',
		'description' 	=> __('Railroad Beach'),
	),
	'treedlane' 	=> array(
		'url' 			=> '%s/img/headers/treed-lane.jpg',
		'thumbnail_url'	=> '%s/img/headers/treed-lane-thumbnail.jpg',
		'description' 	=> __('Treed Lane'),
	),
	'skyrose' 		=> array(
		'url' 			=> '%s/img/headers/sky-rose.jpg',
		'thumbnail_url'	=> '%s/img/headers/sky-rose-thumbnail.jpg',
		'description' 	=> __('Roses in the Sky'),
	),
	'sunrisefield' 	=> array(
		'url' 			=> '%s/img/headers/sunrise-field.jpg',
		'thumbnail_url'	=> '%s/img/headers/sunrise-field-thumbnail.jpg',
		'description' 	=> __('Sunrise over a Field'),
	),
	'hiker' 	=> array(
		'url' 			=> '%s/img/headers/hiker.jpg',
		'thumbnail_url'	=> '%s/img/headers/hiker-thumbnail.jpg',
		'description' 	=> __("Hiker's Triumph"),
	),
);
register_default_headers($header_options);

// Content width
if (!isset($content_width)) {
	$content_width = 864;
}

//

// Add automatic feed links
add_theme_support('automatic-feed-links');

// function readium_customize_regsiter($wp_customize) {
// 	$wp_customize->add_section('readium_display_settings', array(
// 		'title'		=> __('Readium Display Settings'),
// 		'priority'	=> 30,
// 	));
// 	$wp_customize->add_setting('Listing Display Format', array(
// 		'default' 	=> 'excerpt',

// 	));
// }

// Custome comment output
function readium_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);
		$args['avatar_size'] = 32;
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
		'url'    => '<p class="form-item label-inline comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
		'<span class="input-holder"><input id="url" name="url" type="text" class="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></span></p>',
	);
	
	// build our new defaults array (based off of default defaults. customized values noted.
	$defaults = array(
		'fields'               => apply_filters('comment_form_default_fields', $fields ), /* customized */
		'comment_field'        => '<p class="form-item comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><span class="input-holder"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></span></p>', /* customized */
		'must_log_in'          => '<p class="must-log-in help">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as help">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes help">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<p class="some-html-allowed help">' . sprintf(__('<a title="%s">Some</a> <abbr title="Hyper Text Markup Language">HTML</abbr> allowed.'), allowed_tags()) . '</p>', /* customized */
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Comment' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel comment' ),
		'label_submit'         => __( 'Post Comment' )
	);
	
	// send them back out! Bam!
	return $defaults;
}

add_filter('comment_form_defaults', 'readium_comment_form');

/**
 * Functions available in templates
*/

// Function(s) to generate a list of links for sharing
function get_share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {

	$url = urlencode($url);
	$title = urlencode($title);

	$output = '';
	$output .= '<ul class="' . $class . '">' . "\n";
	$output .= "\t" . '<li><a href="http://www.facebook.com/sharer.php?s=100&amp;p[title]={{title}}&amp;p[url]={{url}}" class="facebook"><i class="{{icon_prefix}}facebook"></i> Facebook</a></li>' . "\n";
	$output .= "\t" . '<li><a href="https://twitter.com/intent/tweet?url={{url}}&amp;text={{title}}" class="twitter"><i class="{{icon_prefix}}twitter"></i> Twitter</a></li>' . "\n";
	$output .= "\t" . '<li><a href="https://alpha.app.net/intent/post?url={{url}}&amp;text={{title}}" class="adn"><i class="{{icon_prefix}}adn"></i> App.net</a></li>' . "\n";
	$output .= "\t" . '<li><a href="https://plus.google.com/share?url={{url}}" class="gplus"><i class="{{icon_prefix}}google-plus"></i> Google +</a></li>' . "\n";
	$output .= "\t" . '<li><a href="mailto:?&amp;Subject={{title}}&amp;Body={{url}}" class="email"><i class="{{icon_prefix}}envelope"></i> Email</a></li>' . "\n";
	$output .= '</ul>';

	$output = preg_replace('/{{url}}/', $url, $output);
	$output = preg_replace('/{{title}}/', $title, $output);
	$output = preg_replace('/{{icon_prefix}}/', $icon_prefix, $output);

	return $output;
}
function share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-') {
	echo get_share_links($url, $title, $class = 'sharing-list', $icon_prefix = 'fa fa-');
}