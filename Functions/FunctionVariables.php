<?php

// -----------------------------------------------------------------------------
// @section     Function Variables
// @description Variables globales du thème Scriptura
// -----------------------------------------------------------------------------

	// Variables globales
	$uri = '//' .$_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];	// Alternative à get_permalink()
	$root = str_replace( 'index.php', '', $_SERVER[ 'SCRIPT_NAME' ] );
	$slug = str_replace( $root, '', $_SERVER[ 'REQUEST_URI' ] );
	$slug = explode( '/', $slug );

	$version = date( dmy ); // Versioning pour certains fichiers css et js

	$siteName = get_bloginfo( 'name' ); // Nom du site
	$siteUri = get_bloginfo( 'url' ); // Url du site
	$templateUri = get_bloginfo( 'template_directory' ); // get_template_directory_uri() // Emplacement du thème
	$imgDefault = $templateUri . '/Images/Default.jpg';

	global $current_user;

	$userLogin = $current_user->user_login;
	$userEmail = $current_user->user_email;
	$userLevel = $current_user->user_level;
	$userFirstName = $current_user->user_firstname;
	$userLastName = $current_user->user_lastname;
	$userDisplayName = $current_user->display_name;
	$userId = $current_user->ID;

	global $gravatarUri;
