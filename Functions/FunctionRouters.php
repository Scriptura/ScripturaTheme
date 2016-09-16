<?php

// -----------------------------------------------------------------------------
// @section     Function Router
// @description Routage spécifiques
// -----------------------------------------------------------------------------

// @link https://www.grafikart.fr/tutoriels/wordpress/inscription-connexion-perso-282

if ( !is_admin() ) :

function ScripturaRouter()
{ // @note Capture du permalien -> redirection sur une page template

	global $slug;

	if( count( $slug ) == 1 AND $slug[0] == 'Login' )
		require locate_template( 'Templates/Login.php' );
	if( count( $slug ) == 1 AND $slug[0] == 'Register' )
		require locate_template( 'Templates/Register.php' );
	if( count( $slug ) == 1 AND $slug[0] == 'Profile' )
		require locate_template( 'Templates/Profile.php' );
}

add_action( 'send_headers', 'ScripturaRouter' ); // @note Gestion des en-têtes HTTP

endif; // admin


// @subsection  Logout Redirect
// @description Redirection après déconnection
// -----------------------------------------------------------------------------

// @link https://developer.wordpress.org/reference/functions/wp_redirect/

function ScripturaLogoutRedirect()
{
	//wp_redirect( get_site_url() . '/Login' );
	require locate_template( 'Templates/Login.php' );
	exit;
}
add_action( 'wp_logout', 'ScripturaLogoutRedirect' );