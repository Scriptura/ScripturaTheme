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
		$postLink = str_replace( $arrayHttp, '//', get_permalink() );
		$resume = get_the_excerpt();
		$resume = str_replace( '&nbsp; ', '', $resume ); // Suppression des espaces blancs induits par les shortcodes
		$longResume = false;
		$longTitle = false;
		if ( strlen( $resume ) > 160 ) // En nombre de caractères
			$longResume = true;
		if ( strlen( strip_tags( $title ) ) > 90 ) // En nombre de caractères, moins les tags html
			$longTitle = true;
		$restrictedRead = get_post_meta( $post->ID, 'restrictedread', true );
		$authorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );
		$rightGroups = ScripturaRightsManagementGroups( $userGroups, $authorizedGroups );
		//var_dump( $rightGroups );
		echo '<article class="box0 m3 sizeS-m6 sizeL-m4 ribbon-container-bottom protected">';
		echo '<a href="' . $postLink . '">';
		if ( ! $capacityAdministrator AND ( $restrictedRead AND ! $capacityRead OR $authorizedGroups AND ! $rightGroups ) ) {
			$image1000 = $imageProtected1000;
		} elseif ( has_post_thumbnail() ) {
			ob_start();
			the_post_thumbnail_url( 'image1000' );
			$image1000 = ob_get_clean();
		} elseif ( get_option( 'scriptura_def_thumbnail' ) ) {
			$image1000 = str_replace( $arrayHttp, '//', get_option( 'scriptura_def_thumbnail' ) );
		} else {
			$image1000 = $templateUri . '/Images/Default1000.jpg';
		}
		$image1000 = str_replace( $arrayHttp, '//', $image1000);
		echo '<style>#post' . $postId . ' {background-image: url(' . $image1000 . ')}</style>';
		echo '<div class="ratio-1-2 magimg" id="post' . $postId . '"></div>';
		echo '</a>';
		echo '<h2 class="h5"><a href="' . $postLink . '">' . $title . '</a></h2>';
		if ( ( $restrictedRead != false AND $capacityRead == false ) OR ( ! $capacityAdministrator AND $authorizedGroups AND ! $rightGroups ) ) {
			echo '<div class="vertical"><div class="icon-locked zoom800"></div></div>';
		} else {
			if ( ! $longTitle ) {
				if ( $longResume ) {
					echo '<p>' . $resume . '</p>';
				} else {
					echo '<div class="vertical"><div class="icon-ampersand zoom800"></div></div>';
				}
			} else {
				echo '<div class="vertical sizeXS-unhidden"><div class="icon-ampersand zoom800"></div></div>';
			}
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