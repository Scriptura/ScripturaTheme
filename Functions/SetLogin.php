<?php

// -----------------------------------------------------------------------------
// @section     Set Login
// @description Configuration pour la connexion utlisateur
// -----------------------------------------------------------------------------

	$errorLogin = '';
	if( ! empty( $_POST ) ) {
		$user = wp_signon( $_POST );
		if( is_wp_error( $user ) ) {
			$errorLogin = '<p class="message-error">' . __( 'Your password is invalid. Your connection attempt failed.', 'scriptura' ) . '</p>';
		} else {
			header( 'location:Profile' );
		}
	} else {
		$user = wp_get_current_user();
		if( $user->ID != 0 )
			header( 'location:Profile' );
	}

	$name = __( 'Login', 'scriptura' );
	$formAction = $_SERVER[ 'REQUEST_URI' ];
	$formUserLoginText = __( 'Username or email', 'scriptura' );
	$formUserLoginPlaceholder = __( 'Pseudo / pseudo@gmail.com', 'scriptura' );
	$formUserPasswordText = __( 'Password', 'scriptura' );
	$formUserPasswordPlaceholder = '• • • • • • • •';
	$formSaveText = __( 'Save information', 'scriptura' );
	$formSignInText = __( 'Sign in', 'scriptura' );
	$formNotRegisteredText = __( 'Not yet registered?', 'scriptura' );
	$message = __( 'Not registered?', 'scriptura' );
	$register = __( 'Register', 'scriptura' );