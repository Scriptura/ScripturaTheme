<?php

	// @note Certaines fonctions WP ne peuvent être mise dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

	// @documentation
	// - 'ob_start()' enclenche la temporisation de sortie
	// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface

	global $siteUri;

	// Loop WordPress
	if( have_posts() ) {
		while( have_posts() ) : the_post();
		$name = get_the_title();
		$author = get_the_author();
		$created = get_the_date();
		$publisher = 'Editions MachinTruc';
		$dateCreated = $created;
		$addressLocality = 'Paris';
		$pageStart = '57';
		$pageEnd = '58';
		$datePublished = get_the_date();
		$dateModified = get_the_modified_date();
		ob_start();
		if ( get_the_tags() ) {
			$posttags = get_the_tags(); // plus facilement personnalisable que the_tags()
			if ( $posttags ) {
				$keywords = __( 'Keywords', 'scriptura' ) . ': ';
				foreach( $posttags as $tag ) {
					$keywords .= '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a>';
					$keywords .= ', '; // Ajout d'une virgule
				}
			}
			$keywords = rtrim( $keywords, ', ' ); // Suppression de la dernière virgule
			$keywords = $keywords . '.'; // Un point en fin de chaîne
			echo $keywords;
		}
		$keywords = ob_get_clean();
		ob_start();
		the_content();
		$content = ob_get_clean();

		ob_start();
		the_post_thumbnail_url( 'image300' );
		$image300 = ob_get_clean();

		ob_start();
		the_post_thumbnail_url( 'image1000' );
		$image1000 = ob_get_clean();

		ob_start();
		the_post_thumbnail_url( 'image1500' );
		$image1500 = ob_get_clean();

		ob_start();
		the_post_thumbnail_url( 'image2000' );
		$image2000 = ob_get_clean();

		$category = get_the_category()[0]; // Récupération de la première catégorie seulement
		$singleCatLink = get_category_link( $category->cat_ID );
		$singleCatName = $category->cat_name;
		endwhile;
	}

	// Images
	// @note Fonctions en remplacement de 'the_post_thumbnail()' afin de générer du html maîtrisé.
	if ( has_post_thumbnail() ) :
		$imageUri = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false )[ 0 ]; // URL et format de l'image
		if( $imageAlt ) {
			$imageAlt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); // Meta alt
		} else {
			$imageAlt = 'Article image'; // Texte alternatif si meta alt non renseignée
		}
		$image = '
<style>
@media screen and (max-width: 36.01rem) {
  .image-article {
    background-image: url(' . $image1000 . ');
  }
}
@media screen and (min-width: 36.01rem) and (max-width: 65.01rem) {
  .image-article {
    background-image: url(' . $image1500 . ');
  }
}
@media screen and (min-width: 65.01rem) {
  .image-article {
    background-image: url(' . $image2000 . ');
  }
}
</style>
'
			   . '<header>'
			   . '<div class="image-article">'
			   . '<picture>'
			   . '<source srcset="' . $image300 . '" sizes="100vw">'
			   . '<img src="' . $imageUri . '" alt="' . $imageAlt . '" itemprop="image">'
			   . '</picture>'
			   . '</div>'
			   . '</header>' . "\n";
	endif;

	$separator = ', ';

	if( $author ) :
		$reference = '<span itemprop="author" class="author">' .$author. '</span>';
	endif;
	if( $name ) :
		$reference .= $separator;
		$reference .= '<em itemprop="alternativeHeadline">' . $name . '</em>';
	endif;
	if( $translator ) :
		$reference .= $separator;
		$reference .= 'tr. <span itemprop="translator">' . $translator . '</span>';
	endif;
	if( $publisher ) :
		$reference .= $separator;
		$reference .= '<span itemprop="publisher">' . $publisher . '</span>';
	endif;
	if( $addressLocality ) :
		$reference .= $separator;
		$reference .= '<span itemprop="locationCreated" itemscope itemtype="https://schema.org/Place">';
		$reference .= '<span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">';
		$reference .= '<span itemprop="addressLocality">' . $addressLocality . '</span>';
		$reference .= '</span>';
		$reference .= '</span>';
	endif;
	if( $datePublished ) :
		$reference .= $separator;
		$reference .= '<span itemprop="datePublished">' . $datePublished . '</span>';
	endif;
	if( $pageStart AND $pageEnd ) :
		$reference .= $separator;
		$reference .= 'pp. <span itemprop="pagination">';
		$reference .= '<span itemprop="pageStart">' . $pageStart . '</span>';
		$reference .= ' - ';
		$reference .= '<span itemprop="pageEnd">' . $pageEnd . '</span>';
		$reference .= '</span>';
	endif;
	$reference .= '.';

	if( $dateCreated ) :
		$published = __( 'Published on', 'scriptura' );
		$published .= ' <time itemprop="dateCreated" datetime="2015-11-21T20:06:17+00:00">' . $dateCreated . '</time>';
	endif;
	if( $dateModified ) :
		$published .= $separator;
		$published .= __( 'modified on', 'scriptura' );
		$published .= ' <time itemprop="dateModified" datetime="2015-11-21T20:06:17+00:00">' . $dateModified . '</time>';
		$published .= '.';
	endif;

	$editPost = get_edit_post_link();


// BEGIN $relation

	ob_start();

	// Gestion des tags :
	$tags = wp_get_post_tags( $post->ID ); // Récupération des mots clefs associés à l'article en cours
	if ( $tags ) :
	$tag_ids = array();
	foreach( $tags as $individual_tag ) $tag_ids[] = $individual_tag->term_id;
	endif;
	$args = [
		'tag__in' => $tag_ids,
		//'category__in' => $cat_ids,
		'order' => 'ASCs',
		'post__not_in' => array( $post->ID ),	// Ignorer le post en cours
		'posts_per_page' => '4',				// Nombre de résultats max
		'ignore_sticky_posts' => '1'			// Ignore les posts mis en avant
		//'order' => 'ASCs'
	];
	$rel = new WP_Query( $args );
	while ( $rel->have_posts() ) : $rel->the_post();

    $postId = get_the_ID();

	if ( has_post_thumbnail() ) {
		ob_start();
		the_post_thumbnail_url( 'image1000' );
		$image1000 = ob_get_clean();
	} elseif ( get_option( 'scriptura_def_thumbnail' ) ) {
		$image1000 = get_option( 'scriptura_def_thumbnail' );
	} else {
		$image1000 = $templateUri . '/Images/Default.jpg';
	}
	echo '<a href="' . get_the_permalink() . '" class="ribbon-container" itemprop="relatedLink">';
	echo '<style>#relation' . $postId . ' {background-image: url(' . $image1000 . ')}</style>';
	echo '<div class="ratio-16-9" id="relation' . $postId . '"></div>';
	echo '<h2>' . get_the_title() . '</h2>';
	echo '<div class="ribbon"><span>' . __( 'Read article', 'scriptura' ) . '</span></div>';
	echo '</a>' . "\n";
	endwhile;
	wp_reset_query();

/*
	// Gestion des catégories :
	$categories = get_the_category();
	if( $categories ) {
	foreach( $categories as $category ) {
	echo '<a href="' . get_category_link( $category->term_id ) . '">';
	echo '<figure>';
	if ( get_option( 'scriptura_def_thumbnail' ) ) :
	echo '<img width="119" height="58" src="' . $scriptura_def_thumbnail2_uri . '" alt="Image par défaut">';
	else :
	echo '<div width="119" height="58"></div>';
	endif;
	echo '<figcaption>' . $category->cat_name . '</figcaption>';
	echo '</figure>';
	echo '</a>' . "\n";
	}
	}
*/

	$relation = ob_get_clean();

// END $relation
