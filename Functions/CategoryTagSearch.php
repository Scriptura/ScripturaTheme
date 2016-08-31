<?php

// -----------------------------------------------------------------------------
// @section     Category Tag Search
// @description Configuration commune pour les pages susnommées
// -----------------------------------------------------------------------------

	ob_start();
	if( have_posts() ) {
	while( have_posts() ) : the_post();

	    $postId = get_the_ID();
	    $title = get_the_title();
		$postLink = str_replace( 'http:', '', get_permalink() );
		$resume = get_the_excerpt();
		$restrictedRead = get_post_meta( $post->ID, 'restrictedread', true );
		$authorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );
		//var_dump( $restrictedRead );die();

		echo '<article class="box0 m3 sizeS-m6 sizeL-m4 ribbon-container-bottom protected">';
		echo '<a href="' . $postLink . '">';
		if ( ( $restrictedRead AND ! $capacityRead ) OR ( ! $capacityAministrator AND $userGroup != $authorizedGroups ) ) {
			$image1000 = $templateUri . '/Images/Protected1000.jpg';
		} elseif ( has_post_thumbnail() ) {
			ob_start();
			the_post_thumbnail_url( 'image1000' );
			$image1000 = ob_get_clean();
		} elseif ( get_option( 'scriptura_def_thumbnail' ) ) {
			$image1000 = str_replace( 'http:', '', get_option( 'scriptura_def_thumbnail' ) );
		} else {
			$image1000 = $templateUri . '/Images/Default1000.jpg';
		}
		echo '<style>#post' . $postId . ' {background-image: url(' . $image1000 . ')}</style>';
		echo '<div class="ratio-1-2 magimg" id="post' . $postId . '"></div>';
		echo '</a>';
		echo '<h2 class="h5"><a href="' . $postLink . '">' . $title . '</a></h2>';
		if ( $restrictedRead != false AND $capacityRead == false ) {
			echo '<p class="message-error">' . __( 'This content is only visible to connected users.', 'scriptura' ) . '</p>';
		} elseif ( ! $capacityAministrator AND $userGroup != $authorizedGroups ) {
			echo '<p class="message-error">' . __( 'This content is only visible to authorized users.', 'scriptura' ) . '</p>';
		} else {
			echo '<p>' . $resume . '</p>';
		}
		echo '<div class="ribbon"><a href="' . $postLink . '">' . __( 'Read more', 'scriptura' ) . '</a></div>'
		   . '</article>';
	endwhile;
	wp_reset_postdata();
	} else {
		echo '<p class="message-error">' . __( 'This query yielded no results.', 'scriptura' ) . '</p>';
	}
	$content = ob_get_clean();
	$titleSearchForm = __( 'Search form', 'scriptura' );