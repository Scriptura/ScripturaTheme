<?php

	// @note Certaines fonctions WP ne peuvent être mise dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

	// @documentation
	// - 'ob_start()' enclenche la temporisation de sortie
	// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface

	$name = __( 'Login', 'scriptura' );

	$formAction = $_SERVER[ 'REQUEST_URI' ];
	$formUserLoginText = __( 'Username or email', 'scriptura' );
	$formUserLoginPlaceholder = __( 'Pseudo / pseudo@gmail.com', 'scriptura' );
	$formUserPasswordText = __( 'Password', 'scriptura' );
	$formUserPasswordPlaceholder = '• • • • • • • •';
	$formSaveText = __( 'Save information', 'scriptura' );
	$formSignInText = __( 'Sign in', 'scriptura' );
	$formNotRegisteredText = __( 'Not yet registered?', 'scriptura' );

	$errorLogin = false;
	if( !empty( $_POST ) ) :
	$user = wp_signon( $_POST );
	if( is_wp_error( $user) ) :
	$errorLogin = '<p class="message-error">' .__( 'Your password is invalid. Your connection attempt failed.', 'scriptura' ). '</p>';
	else :
	header( 'location:Profil' );
	endif;
	else :
	$user = wp_get_current_user();
	if( $user->ID != 0 ) :
	header( 'location:Profil' );
	endif;
	endif;
