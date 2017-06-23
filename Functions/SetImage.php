<?php

// -----------------------------------------------------------------------------
// @section     Set Image
// @description Page du fichier joint
// -----------------------------------------------------------------------------

	// @note Depuis WordPress 3.5 une page est créé par défaut pour chaque média uploadé. Cette option est très discutable...

	// Supprimer la page du fichier joint
	global $post;
	if ( $post AND $post->post_parent ) {
		wp_redirect( get_permalink( $post->post_parent ), 301 ); // Redirection sur la page de l'article à l'origine de l'upload
	} else {
		wp_redirect( home_url( '/' ), 301 ); // Sur la page d'accueil le cas échéant
	}
	exit;
