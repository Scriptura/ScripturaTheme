<?php

// -----------------------------------------------------------------------------
// @section     Set Sitemap
// @description Plan du site
// -----------------------------------------------------------------------------

	$editPost = get_edit_post_link();

	$name = get_the_title();

	ob_start();
	$content = '';
	if( have_posts() ) {
		$recentPosts = new WP_Query( [
			'posts_per_page' => 7,
			'ignore_sticky_posts' => true
		] );
		$content .= '<h2 class="h3">' . __( 'Latest Articles', 'scriptura' ) . '<a href="#index-latest-articles" class="anchor"></a><span id="index-latest-articles"></span></h2>';
		$content .= '<div class="grid">';
		$content .= '<div class="m6 sizeS-m12">';
		$content .= '<ol class="list-number">';
		while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
		$content .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
		endwhile;
		$content .= '</ol>';
		$content .= '</div>';
		$content .= '<div class="m6 sizeS-m12 vertical"><div class="icon-list2 surround zoom500"></div></div>';
		$content .= '</div>';
		wp_reset_postdata(); // @note Restaure la variable globale $post de la requette principale, sinon certains éléments métas de la page seront basé sur le dernier post appelé dans la boucle
	}
	$cats = get_categories();
	if ( $cats ) {
		$content .= '<h2 class="h3">' . __( 'Categories', 'scriptura' ) . '<a href="#index-categories" class="anchor"></a><span id="index-categories"></span></h2>';
		$content .= '<div class="list-stripe summary">';
		foreach ( $cats as $cat ) {
			$cat_link = get_tag_link( $cat->term_id );
			$content .= '<a href="' . $cat_link . '">' . $cat->name . '</a>';
		}
		$content .= '</div>';
	}
	$tags = get_tags();
	if ( $tags ) {
		$content .= '<h2 class="h3">' . __( 'Keywords', 'scriptura' ) . '<a href="#index-keywords" class="anchor"></a><span id="index-keywords"></span></h2>';
		$content .= '<div class="list-stripe summary">';
		foreach ( $tags as $tag ) {
			$tag_link = get_tag_link( $tag->term_id );
			$content .= '<a href="' . $tag_link . '">' . $tag->name . '</a>';
		}
		$content .= '</div>';
	}
	$content .= ob_get_clean();
	return $content;