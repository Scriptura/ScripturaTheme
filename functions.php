<?php

// -----------------------------------------------------------------------------
// @section     Functions
// @description Fichiers d'appel aux fonctions
// -----------------------------------------------------------------------------

// @link https://make.wordpress.org/themes/handbook/review/
// @note Les fonctionnalités de ce thème recourent au minimum à WordPress 4.4

	//phpinfo ( -1 );
	ini_set( 'display_errors', 1 ); // Affiche les erreurs php
	error_reporting( E_ALL ); // Rapporte toutes les erreurs et les notices
	error_reporting( 0 ); // Ne retourne aucune erreur

	require_once locate_template( 'Functions/FunctionVariables.php' );
	require_once locate_template( 'Functions/FunctionRouter.php' );
	require_once locate_template( 'Functions/FunctionSetup.php' );
	require_once locate_template( 'Functions/FunctionHead.php' );
	require_once locate_template( 'Functions/FunctionScripts.php' );
	require_once locate_template( 'Functions/FunctionImages.php' );
	require_once locate_template( 'Functions/FunctionPlayers.php' );
	require_once locate_template( 'Functions/FunctionWidgets.php' );
	require_once locate_template( 'Functions/FunctionWysiwyg.php' );
	require_once locate_template( 'Functions/FunctionSearchForm.php' );
	require_once locate_template( 'Functions/FunctionUsers.php' );
	require_once locate_template( 'Functions/FunctionArticles.php' );
	require_once locate_template( 'Functions/FunctionPannel.php' );
	require_once locate_template( 'Functions/FunctionPannelOptions.php' );
	require_once locate_template( 'Functions/FunctionPannelIdentity.php' );
	require_once locate_template( 'Functions/FunctionPannelUsers.php' );
	require_once locate_template( 'Functions/FunctionPannelForms.php' );

