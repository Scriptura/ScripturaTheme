<?php

// -----------------------------------------------------------------------------
// @section     Functions
// @description Fichiers d'appel aux fonctions
// -----------------------------------------------------------------------------

// @link https://make.wordpress.org/themes/handbook/review/
// @note Les fonctionnalités de ce thème recourent au minimum à WordPress 4.4

//	phpinfo ( -1 );
	require_once locate_template( 'Functions/FunctionVariables.php' );
	require_once locate_template( 'Functions/FunctionRouter.php' );
	require_once locate_template( 'Functions/FunctionSetup.php' );
	require_once locate_template( 'Functions/FunctionHead.php' );
	require_once locate_template( 'Functions/FunctionScripts.php' );
	require_once locate_template( 'Functions/FunctionImages.php' );
	require_once locate_template( 'Functions/FunctionPlayers.php' );
	require_once locate_template( 'Functions/FunctionWysiwyg.php' );
	require_once locate_template( 'Functions/FunctionUsers.php' );
	require_once locate_template( 'Functions/FunctionPannel.php' );
	require_once locate_template( 'Functions/FunctionPannelOptions.php' );
	require_once locate_template( 'Functions/FunctionPannelIdentity.php' );
	require_once locate_template( 'Functions/FunctionPannelUsers.php' );
	require_once locate_template( 'Functions/FunctionPannelForms.php' );
	require_once locate_template( 'Functions/FunctionSearchForm.php' );


// -----------------------------------------------------------------------------
// @subsection  Login WordPress
// @description Style particulier pour la page login de WordPress
// -----------------------------------------------------------------------------

/*
if ( !is_admin() ) :

// Annulation des styles par défaut
if ( basename( $_SERVER['PHP_SELF'] ) == 'wp-login.php' ) {
	add_action( 'style_loader_tag', create_function( '$a', 'return null;' ));
}

// Chemin de la nouvelle feuille de style
function scripturaCustomLogin() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'stylesheet_directory' ) . '/Public/Styles/MainRatatouille.css" />';
}
add_action( 'login_head', 'scripturaCustomLogin' );

// Lien par defaut de la page de connexion
function scripturaUrlLogin() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'scripturaUrlLogin' );

endif; // admin
*/


