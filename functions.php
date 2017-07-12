<?php

// -----------------------------------------------------------------------------
// @section     Functions
// @description Fichiers d'appel aux fonctions
// -----------------------------------------------------------------------------

// @note Configuration minimum pour le thème : PHP 7 et WordPress 4.4
// @note La déclaration ini_set() permet d'harmoniser les configurations php proposées selon les serveurs (ex : 1&1 vs OVH)

	//phpinfo ( -1 );
	ini_set( 'display_errors', 1 ); // @note Affiche les erreurs php
	error_reporting( E_ALL ); // @note Rapporte toutes les erreurs et les notices
	error_reporting( 0 ); // @note Ne retourne aucune erreur

	require_once locate_template( 'Functions/FunctionVariables.php' );
	require_once locate_template( 'Functions/FunctionRouters.php' );
	require_once locate_template( 'Functions/FunctionSetup.php' );
	require_once locate_template( 'Functions/FunctionHead.php' );
	require_once locate_template( 'Functions/FunctionScripts.php' );
	require_once locate_template( 'Functions/FunctionImages.php' );
	require_once locate_template( 'Functions/FunctionPlayers.php' );
	require_once locate_template( 'Functions/FunctionWidgets.php' );
	require_once locate_template( 'Functions/FunctionWysiwyg.php' );
	//require_once locate_template( 'Functions/FunctionSearch.php' );
	require_once locate_template( 'Functions/FunctionSearchForm.php' );
	require_once locate_template( 'Functions/FunctionUsers.php' );
	require_once locate_template( 'Functions/FunctionArticles.php' );
	require_once locate_template( 'Functions/FunctionPannel.php' );
	require_once locate_template( 'Functions/FunctionPannelOptions.php' );
	require_once locate_template( 'Functions/FunctionPannelIdentity.php' );
	require_once locate_template( 'Functions/FunctionPannelUsers.php' );
	require_once locate_template( 'Functions/FunctionPannelForms.php' );
	require_once locate_template( 'Functions/FunctionCalendar.php' );
	require_once locate_template( 'Functions/FunctionMoonPhases.php' );

