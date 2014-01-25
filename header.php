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
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Amatic+SC:400,700" type="text/css" />
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
					<?php
						$header_image = readium_custom_header_image();
					?>
					<header id="site-header"<?php echo (!$header_image) ? ' class="no-image"' : ' style="background-image:url(' . $header_image['url'] . ')"'; ?>>
						<div id="site-id">
							<div class="grid">
								<div class="g12 text-center">
									<?php $title_tag = (!is_single()) ? 'h1' : 'div'; ?>
									<<?php echo $title_tag; ?> id="site-title"><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></<?php echo $title_tag; ?>>
								</div>
							</div>
						</div>
						<?php if (is_singular()) : ?>
						<div id="page-header-overlay">
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
						</div>
						<?php endif; ?>
					</header>
					