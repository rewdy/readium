<?php /*

Readium Theme
-------------

archiveheading.php

Shows heading for archives file	

*/
?>

<?php

$listing_heading = '';

if (is_home()) {

	$listing_heading = 'Recent Posts';

} else if (is_date()) {

	$date_verbiage = "Posts from ";

	if (is_month()) {
		$listing_heading = $date_verbiage . get_the_date('F Y');
	} else if (is_year()) {
		$listing_heading = $date_verbiage . get_the_date('Y');
	} else if (is_day()) {
		$listing_heading = $date_verbiage . get_the_date();
	} else {
		$listing_heading = 'Post Archive';
	}

} else {

	if (is_category()) {
		$the_category = single_cat_title('', false);
		if ($the_category == 'Uncategorized') {
			$listing_heading = 'Uncategorized posts';
		} else {
			$listing_heading = 'Posts in the category <em>' . single_cat_title('', false) . '</em>';
		}
	} else if (is_tag()) {
		$listing_heading = 'Posts with the tag <em>' . single_tag_title('', false) . '</em>';
	} else if (is_author()) {
		// query the first post to get the author
		the_post();
		$listing_heading = 'Posts published by <em>' . get_the_author() . '</em>';
		// reset loop since we had to used it to get the author
		rewind_posts();
	} else {
		$listing_heading = 'Post Archive';
	}

}


?>

<h1><?php echo $listing_heading; ?></h1>

<?php if (is_category()) : ?>
	<?php if (category_description()!='') : ?>
	<p class="category-description attn"><?php echo category_description(); ?></p>
	<?php endif; ?>
<?php endif; ?>

