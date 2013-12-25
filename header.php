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
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.5">

		<!-- Links -->
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<!-- Stylesheets -->
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700" type="text/css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

		<!-- Javascript -->
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/script.js"></script>


        <?php 
        if (is_singular() && get_option('thread_comments')) :
        	wp_enqueue_script('comment-reply');
        endif;
        ?>
        <!-- Wordpress Stuff -->
        <?php wp_head(); ?>

	</head>
	<body>

		<div id="control">
			
			<?php get_template_part('drawer'); ?>

			<div id="page">
				<div id="wrapper">
					
					<header id="site-header"<?php echo (get_header_image()=='') ? ' class="no-image"' : ''; ?>>
						<div id="site-header-overlay">
							<div class="grid">
								<div id="site-header-text" class="g12 text-center">
									<?php $title_tag = (!is_single()) ? 'h1' : 'div'; ?>
									<<?php echo $title_tag; ?> id="site-title"><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></<?php echo $title_tag; ?>>

									<?php if (get_bloginfo('description') != '') : ?>
									<div id="site-tagline"><?php bloginfo('description'); ?></div>
									<?php endif; ?>

								</div>
							</div>
						</div>
						<div id="deco" style="background-image:url(<?php header_image(); ?>)">
							<!-- Image not visible but used for sizing -->
							<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
						</div>
					</header>
					