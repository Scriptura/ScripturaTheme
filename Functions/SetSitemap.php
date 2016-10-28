<?php

// -----------------------------------------------------------------------------
// @section     Set Sitemap
// @description Plan du site
// -----------------------------------------------------------------------------

	$name = get_the_title();

	ob_start();
	$content = '';
	$content .= '<h2 class="h3">' . __( 'Categories', 'scriptura' ) . '</h2>';
	$content .= '<div class="list-stripe summary">';
	$cats = get_categories();
	foreach ( $cats as $cat ) {
		$cat_link = get_tag_link( $cat->term_id );
		$content .= '<a href="' . $cat_link . '">' . $cat->name . '</a>';
	}
	$tags = get_tags();
	$content .= '</div>';
	$content .= '<h2 class="h3">' . __( 'Keywords', 'scriptura' ) . '</h2>';
	$content .= '<div class="list-stripe summary">';
	foreach ( $tags as $tag ) {
		$tag_link = get_tag_link( $tag->term_id );
		$content .= '<a href="' . $tag_link . '">' . $tag->name . '</a>';
	}
	$content .= '</div>';
	$content .= ob_get_clean();
	return $content;
