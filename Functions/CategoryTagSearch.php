<?php

	ob_start();
	if( have_posts() ) {
	while( have_posts() ) : the_post();

	    $postId = get_the_ID();
	    $title = get_the_title();
		$postLink = get_permalink();
		$resume = get_the_excerpt();

		echo '<article class="box0 m3 sizeS-m6 sizeL-m4 ribbon-container-bottom">';
		echo '<a href="' . $postLink . '">';
		if ( has_post_thumbnail() ) {
			ob_start();
			the_post_thumbnail_url( 'image1000' );
			$image1000 = ob_get_clean();
		} elseif ( get_option( 'scriptura_def_thumbnail' ) ) {
			$image1000 = get_option( 'scriptura_def_thumbnail' );
		} else {
			$image1000 = $templateUri . '/Images/Default.jpg';
		}
		echo '<style>#post' . $postId . ' {background-image: url(' . $image1000 . ')}</style>';
		echo '<div class="ratio-1-2 magimg" id="post' . $postId . '"></div>';
		echo '</a>';
		echo '<h2 class="h5"><a href="' . $postLink . '">' . $title . '</a></h2>'
		   . '<p>' . $resume . '</p>'
		   . '<div class="ribbon"><a href="' . $postLink . '">' . __( 'Read more', 'scriptura' ) . '</a></div>'
		   . '</article>';
	endwhile;
	wp_reset_postdata();
	}
	$content = ob_get_clean();

