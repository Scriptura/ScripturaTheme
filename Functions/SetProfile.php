<?php

// -----------------------------------------------------------------------------
// @section     Set Profile
// @description Configuration pour la page de profil utlisateur
// -----------------------------------------------------------------------------

	// @note Certaines fonctions WP ne peuvent être mise dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

	// @documentation
	// - 'ob_start()' enclenche la temporisation de sortie
	// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface

	// Vérification utilisateur connecté
	$user = wp_get_current_user();
	if ( $user->ID == 0 ) :
	header( 'location:Login' );
	endif;

	global $current_user;
	$userDisplayName = $current_user->display_name;
	//$name = __( 'Hello', 'scriptura' ) . ' ' . $userDisplayName;
	$name = __( 'Your profile', 'scriptura' );

	$logoutUri = wp_logout_url( '//' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] );

	$textLogout = __( 'Logout', 'scriptura' );
	$adminUri = get_bloginfo( 'url' ) . '/wp-admin/';
	$textAdmin = __( 'Administration', 'scriptura' );

