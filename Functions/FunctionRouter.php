<?php

// -----------------------------------------------------------------------------
// @section     Function Router
// @description Routage dédié aux pages spécifiques du thème
// -----------------------------------------------------------------------------

// @link https://www.grafikart.fr/tutoriels/wordpress/inscription-connexion-perso-282

if ( !is_admin() ) :

function ScripturaRouter()
{ // @note Capture du permalien -> redirection sur une page template

	global $slug;

	if( count( $slug ) == 1 AND $slug[0] == 'Login' ) :
	require locate_template( 'Templates/Login.php' );
	endif;
	if( count( $slug ) == 1 AND $slug[0] == 'Register' ) :
	require locate_template( 'Templates/Register.php' );
	endif;
	if( count( $slug ) == 1 AND $slug[0] == 'Profil' ) :
	require locate_template( 'Templates/Profil.php' );
	endif;
}

add_action( 'send_headers', 'ScripturaRouter' ); // @note Gestion des en-têtes HTTP

endif; // admin
