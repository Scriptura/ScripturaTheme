<?php

// -----------------------------------------------------------------------------
// @section     Set Single
// @description Configuration pour les pages d'articles
// -----------------------------------------------------------------------------

// @note Certaines fonctions WP ne peuvent être mises dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

// @documentation
// - 'ob_start()' enclenche la temporisation de sortie
// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface
	global $siteUri;
	if( have_posts() ) {
		while( have_posts() ) : the_post();
		$name = get_the_title();
		$author = get_the_author();
		//$publisher = 'Editions MachinTruc';
		$addressLocality = get_post_meta( $post->ID, 'addresslocality', true );
		$dateDocumentPublished = get_post_meta( $post->ID, 'datedocumentpublished', true );
		$pageStart = false;
		$pageEnd = false;
		// @documentation `get_the_date()` vs `get_the_time()` :
		// @link http://wordpress.stackexchange.com/questions/27183/whats-the-difference-between-get-the-time-and-get-the-date
		// @link https://codex.wordpress.org/Formatting_Date_and_Time
		// @params 'c' = DATE_W3C
		$datePublished = get_the_date();
		$datePublishedIso = get_the_date( 'c' );
		$dateModified = get_the_modified_date();
		$dateModifiedIso = get_the_modified_date( 'c' );
		$restrictedRead = get_post_meta( $post->ID, 'restrictedread', true );
		$authorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );
		$rightGroups = ScripturaRightsManagementGroups( $userGroups, $authorizedGroups );

		ob_start();
		if ( get_the_tags() ) {
			$posttags = get_the_tags(); // plus facilement personnalisable que the_tags()
			$keywords = ' <span itemprop="keywords">';
			if ( $posttags ) {
				$count = 0;
				foreach( $posttags as $tag ) {
					$count++;
					$keywords .= '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a>';
					$keywords .= ', '; // Ajout d'une virgule
				}
			}
			$keywords = rtrim( $keywords, ', ' ); // Suppression de la dernière virgule
			$keywords = $keywords . '</span>.'; // Un point en fin de chaîne
			//$label = _n( 'Keyword:', 'Keywords:', $count, 'scriptura' ); // Problème d'utilisation de la fonction _n() avec Poedit
			if ( $count == 1 ) {
				$label = __( 'Keyword:', 'scriptura' );
			} else {
				$label = __( 'Keywords:', 'scriptura' );
			}
			$keywords = $label . $keywords;
			echo $keywords;
		}
		$keywords = ob_get_clean();
//		if ( ( $restrictedread != 1 AND $capacityRead == false ) AND ( $capacityAdministrator OR $authorizedGroups == '' OR $authorizedGroups == $userGroups ) ) {
		ob_start();
		if ( $restrictedRead AND ! $capacityRead ) {
			echo '<p class="message-error">' . __( 'This content is only visible to connected users.', 'scriptura' ) . '</p>';
		} elseif ( ! $capacityAdministrator AND $authorizedGroups AND ! $rightGroups ) {
			echo '<p class="message-error">' . __( 'This content is only visible to authorized users.', 'scriptura' ) . '</p>';
		} else {
			the_content();
		}
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
		if ( is_single() ) { // Exclu les pages
			$category = get_the_category()[ 0 ]; // Récupération de la première catégorie seulement
			$singleCatLink = get_category_link( $category->cat_ID );
			$singleCatName = $category->cat_name;
		}
		endwhile;
	}
	// Images
	// @note Fonctions en remplacement de 'the_post_thumbnail()' afin de générer du html maîtrisé.
	$image = '';
	if ( has_post_thumbnail() ) {
		$imageUri = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false )[ 0 ]; // URL et format de l'image
		$imageAlt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); // Meta alt
		if ( $imageAlt ) {
			$imageAlt = $imageAlt;
		} else {
			$imageAlt = 'Article image'; // Texte alternatif si meta alt non renseignée
		}
		if ( ( $restrictedRead AND ! $capacityRead ) OR ( ! $capacityAdministrator AND $authorizedGroups AND ! $rightGroups ) ) { // Si fichier protégé alors image et description de remplacement
			$image300 = $imageProtected300;
			$image1000 = $imageProtected1000;
			$image1500 = $imageProtected1500;
			$image2000 = $imageProtected2000;
			$imageUri = $imageProtected300;
			$imageAlt = __( 'Protected content', 'scriptura' );
		}
		$image = '<header>' . PHP_EOL
			   . '<div class="image-article">' . PHP_EOL
			   . '<style scoped>
@media screen and (max-width: 36.01rem) {
  .image-article {
    background-image: url(' . str_replace( $arrayHttp, '//', $image1000 ) . ');
  }
}
@media screen and (min-width: 36.01rem) and (max-width: 65.01rem) {
  .image-article {
    background-image: url(' . str_replace( $arrayHttp, '//', $image1500 ) . ');
  }
}
@media screen and (min-width: 65.01rem) {
  .image-article {
    background-image: url(' . str_replace( $arrayHttp, '//', $image2000 ) . ');
  }
}
</style>' . PHP_EOL
			   . '<picture itemprop="image" itemscope itemtype="http://schema.org/ImageObject">' . PHP_EOL
			   . '<source srcset="' . str_replace( $arrayHttp, '//', $image300 ) . '" sizes="100vw">' . PHP_EOL
			   . '<img src="' . str_replace( $arrayHttp, '//', $imageUri ) . '" alt="' . $imageAlt . '" itemprop="url">' . PHP_EOL
			   . '</picture>' . PHP_EOL
			   . '</div>' . PHP_EOL
			   . '</header>' . PHP_EOL;
	}
	$reference = false;
	$authorGivenName = get_post_meta( $post->ID, 'authorgivenname', true );
	$authorFamilyName = get_post_meta( $post->ID, 'authorfamilyname', true );
	$documentName = get_post_meta( $post->ID, 'documentname', true );
	$articleSource = get_post_meta( $post->ID, 'articlesource', true );
	$documentTranslator = get_post_meta( $post->ID, 'documenttranslator', true );
	$addressLocality = get_post_meta( $post->ID, 'addresslocality', true );
	$documentPublisher = get_post_meta( $post->ID, 'documentpublisher', true );
	$dateDocumentPublished = get_post_meta( $post->ID, 'datedocumentpublished', true );
	$separator = ', ';
	if ( ( $authorGivenName OR $authorFamilyName ) AND ( ! $documentName AND ! $articleSource ) ) {
		$reference .= __( 'Author:', 'scriptura' ) . ' ';
	} elseif ( $documentName OR $articleSource ) {
		$reference .= __( 'Source:', 'scriptura' ) . ' ';
	} else {
	}
	if( $authorGivenName OR $authorFamilyName ) {
		$reference .= '<span itemprop="author" class="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name">';
		if( $authorGivenName )
			$reference .= '<span itemprop="givenName">' . $authorGivenName . '</span>';
		if( $authorGivenName AND $authorFamilyName )
			$reference .= ' ';
		if( $authorFamilyName )
			$reference .= '<span itemprop="familyName">' . $authorFamilyName . '</span>';
		$reference .= '</span></span>';
	}
	if( $documentName ) {
		if( $authorGivenName OR $authorFamilyName )
			$reference .= $separator;
		$reference .= '<em itemprop="headline">' . $documentName . '</em>';
	}
	if( $articleSource ) {
		if( $authorGivenName OR $authorFamilyName OR $documentName )
			$reference .= $separator;
		$reference .= '<span>' . $articleSource . '</span>';
	}
	if( $documentTranslator ) {
		if( $reference )
			$reference .= $separator;
		$reference .= 'tr. fr. <span itemprop="translator">' . $documentTranslator . '</span>';
	}
	if( $documentPublisher ) {
		if( $reference )
			$reference .= $separator;
		$reference .= '<span itemprop="publisher">' . $documentPublisher . '</span>';
	}
	if( $addressLocality ) {
		if( $reference )
			$reference .= $separator;
		$reference .= '<span itemprop="locationCreated" itemscope itemtype="https://schema.org/Place">';
		$reference .= '<span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">';
		$reference .= '<span itemprop="addressLocality">' . $addressLocality . '</span>';
		$reference .= '</span>';
		$reference .= '</span>';
	}
	if( $dateDocumentPublished ) {
		if( $reference )
			$reference .= $separator;
		$reference .= '<span>' . $dateDocumentPublished . '</span>';
	}
	if( $pageStart AND $pageEnd ) {
		if( $reference )
			$reference .= $separator;
		$reference .= 'pp. <span itemprop="pagination">';
		$reference .= '<span itemprop="pageStart">' . $pageStart . '</span>';
		$reference .= ' - ';
		$reference .= '<span itemprop="pageEnd">' . $pageEnd . '</span>';
		$reference .= '</span>';
	}
	if( $reference )
		$reference .= '.';
	if( $datePublished ) {
		$published = __( 'Content published on', 'scriptura' );
		$published .= ' <time itemprop="dateCreated datePublished" datetime="' . $datePublishedIso . '">' . $datePublished . '</time>';
	}
	if( $dateModified ) {
		$published .= $separator;
		$published .= __( 'modified on', 'scriptura' );
		$published .= ' <time itemprop="dateModified" datetime="' . $dateModifiedIso . '">' . $dateModified . '</time>';
		$published .= '.';
	}
	$editPost = get_edit_post_link();
	// BEGIN $relation
	ob_start();
	$tag_ids = '';
	$cat_ids = '';
	$tags = wp_get_post_tags( $post->ID ); // Récupération des mots clefs associés à l'article en cours
	if ( $tags ) {
		$tag_ids = [];
		foreach( $tags as $individualTag ) $tag_ids[] = $individualTag->term_id;
	}
	$categories = get_the_category( $post->ID ); // Récupération des catégories associées à l'article en cours
	if( $categories ) {
		$cat_ids = [];
		foreach( $categories as $individualCategory ) $cat_ids[] = $individualCategory->term_id;
	}
	// @note Mixage entre le mot clef et la catégorie
	// @link https://codex.wordpress.org/Class_Reference/WP_Query#Taxonomy_Parameters
	// @link https://codex.wordpress.org/Taxonomies
	$arr = [
		'posts_per_page' => 4,
		//'order' => 'ASC', // @todo Ne pas définir : ce paramètre annulerait l'effort de récupération des posts via 'tax_query'
		'post__not_in' => [ $post->ID ],
		//'tag__in' => $tag_ids, // Variable représentant l'ID d'un des tag du post
		//'category__in' => $cat_ids, // Variable représentant l'ID d'une des catégorie du post
		'tax_query' => [
			'relation' => 'OR',
			[
				'taxonomy' => 'post_tag',
				'field'    => 'term_id',
				'terms'    => $tag_ids
			],
			[
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $cat_ids
			]
		]
	];
	$rel = new WP_Query( $arr );
	while ( $rel->have_posts() ) : $rel->the_post();
    $postId = get_the_ID();
    $postTitle = get_the_title();
    $postLink = str_replace( 'http:', '', get_the_permalink() );
	$restrictedRead = get_post_meta( $post->ID, 'restrictedread', true );
	$authorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );
	$rightGroups = ScripturaRightsManagementGroups( $userGroups, $authorizedGroups );
	if ( ( $restrictedRead AND ! $capacityRead ) OR ( ! $capacityAdministrator AND $authorizedGroups AND $rightGroups ) ) {
		$image1000 = $templateUri . '/Images/Protected1000.jpg';
	} elseif ( has_post_thumbnail() ) {
		ob_start();
		the_post_thumbnail_url( 'image1000' );
		$image1000 = ob_get_clean();
	} elseif ( get_option( 'scriptura_def_thumbnail' ) ) {
		$image1000 = str_replace( 'http:', '', get_option( 'scriptura_def_thumbnail' ) );
	} else {
		$image1000 = $imgDefault1000;
	}
	echo '<a href="' . $postLink . '" class="ribbon-container" itemprop="relatedLink">' . PHP_EOL;
	echo '<div class="ratio-16-9" id="relation' . $postId . '">' . PHP_EOL;
	echo '<style scoped>#relation' . $postId . ' {background-image: url(' . $image1000 . ')}</style>' . PHP_EOL;
	echo '</div>' . PHP_EOL;
	echo '<h2>' . $postTitle . '</h2>' . PHP_EOL;
	echo '<div class="ribbon"><span>' . __( 'Read article', 'scriptura' ) . '</span></div>' . PHP_EOL;
	echo '</a>' . PHP_EOL;
	endwhile;
	wp_reset_postdata();
	$relation = ob_get_clean();
	// END $relation
function ScripturaComments()
{
	// Modification de la liste de commentaires par défaut de WordPress
	// @link https://codex.wordpress.org/Function_Reference/get_comments
	// @link https://developer.wordpress.org/reference/functions/get_comments/
	global $arrayHttp;
	global $capacityEditor;
	$offsetSizeS = false;
	$offsetSub = false;
	$arr = [
		//'number' => 10,
		'post_id' => get_the_ID(),
		'order' => 'ASC'
	];
	$commentsArray = get_comments( $arr );
	$comments = null;
	$i = -1; // Permet de passer la première itération.
	$up = true;
	$i2 = 0;
	foreach ( $commentsArray as $e ) {
		if ( $i == 0 )
			$up = true;
		if ( $i == 6 )
			$up = false;
		if ( $up ) {
			$i++;
		} else {
			$i--;
		}
		if ( $i == 0 ) {
			$offset = '';
		} else {
			$offset = 'o' . $i . ' ';
		}
		$i2++;
		if ( $i2 % 2 == 0 ) { // Teste si l'iteration est paire ou impaire.
			$offsetSizeS = 'sizeS-o3 ';
		} else {
			$offsetSizeS = 'sizeS-o0 ';
		}
		$email = $e->comment_author_email;
		$id = $e->comment_ID;
		$avatar = get_user_meta( $e->user_id, 'avatar', true );
		//$gravatar = '//www.gravatar.com/avatar/' . md5( strtolower( trim( $email ) ) ) . '?d=' . urlencode( $default ) . '&s=' . $size;
		$gravatar = scripturaUserAvatar( $email, '130' );
		$comments .= '<div class="grid">' . PHP_EOL;
		$comments .= '<article class="' . $offset . 'm6 sizeS-m9 ' . $offsetSizeS . 'comment" id="comment-' . $id . '">' . PHP_EOL;
		$comments .= '<header class="author-comment">' . PHP_EOL;
		$comments .= '<div class="avatar" style="background-image:url(';
		if ( $avatar ) {
			$comments .= str_replace( $arrayHttp, '//', $avatar );
		} else {
			$comments .= $gravatar;
		}
		$comments .= ')"></div>' . PHP_EOL;
		$comments .= '<div>' . PHP_EOL;
		$comments .= '<p class="author">';
		if ( $capacityEditor ) // @note Donner la même valeur de capacité au template de destination @see SetAuthor.php
			$comments .= '<a href="' . get_author_posts_url( $e->user_id ) . '">';
		// @note WordPress enregistre le choix du nom publique de l'auteur et le stocke dans la table des commentaires (celui-ci peut être appelé via `$e->comment_author`). Mais si l'utilisateur décide de changer de nom publique l'ancien nom sera tout de même affiché sur les commentaires antérieurs au changement. Pour éviter ce problème on récupère l'ID utilisateur et on passe par `get_userdata()->display_name`.
		$comments .= get_userdata( $e->user_id )->display_name;
		//$comments .= $e->comment_author;
		if ( $capacityEditor )
			$comments .= '</a>';
		$comments .= '</p>' . PHP_EOL;
		$comments .= '<p><time datetime="' . $e->comment_date . '">' . date_i18n( get_option( 'date_format' ), strtotime( $e->comment_date ) ) . '</time></p>' . PHP_EOL;
		$comments .= '</div>' . PHP_EOL;
		$comments .= '<a href="#comment-' . $id . '" title="' . __( 'Index the comment', 'scriptura' ) . '">#</a>' . PHP_EOL;
		$comments .= '</header>' . PHP_EOL;
		$comments .= '<p>' . $e->comment_content . '</p>' . PHP_EOL;
		$comments .= '</article>' . PHP_EOL;
		$comments .= '</grid>' . PHP_EOL;
	}
	// Classe pour la div suivant les items :
	if ( $up == true AND $i == 0 )
		$offsetSub = 'o1 ';
	if ( $up == true AND $i == 1 )
		$offsetSub = 'o2 ';
	if ( $up == true AND $i == 2 )
		$offsetSub = 'o3 ';
	if ( $up == true AND $i == 3 )
		$offsetSub = 'o4 ';
	if ( $up == true AND $i == 4 )
		$offsetSub = 'o5 ';
	if ( $up == true AND $i == 5 )
		$offsetSub = 'o6 ';
	if ( $up == true AND $i == 6 )
		$offsetSub = 'o5 ';
	if ( $up == false AND $i == 5 )
		$offsetSub = 'o4 ';
	if ( $up == false AND $i == 4 )
		$offsetSub = 'o3 ';
	if ( $up == false AND $i == 3 )
		$offsetSub = 'o2 ';
	if ( $up == false AND $i == 2 )
		$offsetSub = 'o1 ';
	if ( $up == false AND $i == 1 )
		$offsetSub = '';
	if ( $up == false AND $i == 0 )
		$offsetSub = 'o1 ';
	//var_dump($up, $i, $offsetSub);die();
	if ( $offsetSizeS == 'sizeS-o0 ' ) {
		$offsetSubSizeS = 'sizeS-o3 ';
	} else {
		$offsetSubSizeS = 'sizeS-o0 ';
	}
	return [ $comments, $offsetSub, $offsetSubSizeS ];
	// $comments : Contenu du commentaire
	// $offsetSub : Classe offset de la div pour le positionnement du commentaire dans la page
	// $offsetSubSizeS : Classe de l'offset pour les définitions d'écran en dessous de "sizeS"
}
function ScripturaCommentForm()
{
	// Modification du html du formulaire de commentaires de WordPress :
	// @link https://developer.wordpress.org/reference/functions/comment_form/
	$arrCommentForm = [
		'id_form'              => false,
		'class_form'           => false,
		'must_log_in'          => false,
		'logged_in_as'         => false,
		'comment_notes_before' => false,
		'comment_notes_after'  => false,
		'title_reply'          => '',
		'title_reply_before'   => '',
		'title_reply_after'    => '',
		'cancel_reply_before'  => '',
		'cancel_reply_after'   => '',
		'cancel_reply_link'    => '',
		'comment_field'        =>  '<div class="input">' . PHP_EOL . '<label for="comment">' . __( 'Message', 'scriptura' ) . '</label><textarea id="comment" name="comment" placeholder="' . __( 'Hello...', 'scriptura' ) . '" required aria-required="true">' . PHP_EOL . '</textarea>' . PHP_EOL . '</div>' . PHP_EOL,
		'submit_button'        => '<button name="submit" type="submit" id="%2$s" class="submit button" value="%4$s" /><span class="icon-checkmark"></span>&nbsp;&nbsp;' . __( 'Submit', 'scriptura' ) . '</button>',
		'fields' => apply_filters( 'comment_form_default_fields', 'author' ),
	];
	ob_start();
	comment_form( $arrCommentForm );
	$html = ob_get_clean();
	return $html;
}
$commentsOpen = comments_open();
$comments = ScripturaComments()[ 0 ];
$commentForm = '<div class="grid"><div class="m6 ' . ScripturaComments()[ 1 ] . '' . ScripturaComments()[ 2 ] . 'sizeS-m9">'
			 . '<h2 class="h4">' . __( 'Add a comment', 'scriptura' ) . '</h2>'
			 . ScripturaCommentForm()
			 . '</div></div>';
$commentsTitle = __( 'Comments', 'scriptura' );
$relationsTitle = __( 'Related Articles', 'scriptura' );
$articleDescription = get_post_meta( $post->ID, 'articledescription', true );

