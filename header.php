<?php /*

Readium Theme
-------------

header.php

Header template file	

*/

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />

		<title><?php (wp_title('', false) != '') ? wp_title('&#8226;', true, 'right') : ''; ?><?php bloginfo('name'); ?></title>

		<!-- Meta -->
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<!-- Links -->
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<!-- Stylesheets -->
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php /* <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700" type="text/css" /> */ ?>

		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

		<?php readium_header_style(); ?>

		<?php
		// Javascript

		// pull in the jQuery
		wp_enqueue_script('jquery');
		// pull in Nivo-gallery
		wp_enqueue_script('nivo-lightbox', get_template_directory_uri() . '/lib/Nivo-Lightbox-1.1/nivo-lightbox.min.js', 'jquery', 1.0);
		// pull in the site js
		wp_enqueue_script('readium_js', get_template_directory_uri() . '/js/readium-script.min.js', 'jquery');

		// comment script
		if (is_singular() && get_option('thread_comments')) :
			wp_enqueue_script('comment-reply');
		endif;
		?>

		<?php 
		// Wordpress header content

		wp_head(); ?>

	</head>
	<body<?php echo (is_admin_bar_showing()) ? ' class="admin-bar"' : ''; ?>>

		<div id="control">
			
			<?php get_template_part('drawer'); ?>

			<div id="page">
				<div id="wrapper">
					<?php
						$header_image = readium_custom_header_image();
					?>
					<header id="site-header"<?php echo (!$header_image) ? ' class="no-image"' : ' style="background-image:url(' . $header_image['url'] . ')"'; ?> data-0="background-position:center 0%" data-top-bottom="background-position:center -150%">
						<div id="site-id" data-0="opacity:1" data-100="opacity:0.2">
							<div class="grid">
								<div class="g12 text-center">
									<?php $title_tag = (!is_single()) ? 'h1' : 'div'; ?>
									<<?php echo $title_tag; ?> id="site-title"><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></<?php echo $title_tag; ?>>
								</div>
							</div>
						</div>
						<?php if (is_singular()) : ?>
						<div id="page-header-overlay" data-0="bottom:25%; opacity:1" data-top-top="bottom:12.5%; opacity:0.8" data-top-bottom="opacity:0.1">
							<div class="grid">
								<div id="page-header-text" class="g12 text-center">
									<h1 id="page-title"><?php the_title(); ?></h1>

									<!-- Page subtitle? Is there such a thing? -->
									<!-- <div id="page-tagline"><?php bloginfo('description'); ?></div> -->
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php if ($header_image) : ?>
						<div id="spacer">
							<!-- Image not visible but used for sizing -->
							<img src="<?php echo $header_image['url']; ?>" width="<?php echo $header_image['width']; ?>" height="<?php echo $header_image['height']; ?>" alt="" />
							<a href="#content-body" id="content-link" title="Scroll to the content"><i class="fa fa-angle-down"></i> <span class="text">Go to content</span></a>
						</div>
						<?php endif; ?>
					</header>
					