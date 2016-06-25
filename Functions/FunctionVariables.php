<?php

// -----------------------------------------------------------------------------
// @section     Function Variables
// @description Variables globales pour le thème
// -----------------------------------------------------------------------------

	$scheme = '//'; // $_SERVER[ 'REQUEST_SCHEME' ]; @todo 'REQUEST_SCHEME' n'est pas encore supporté
	$host = $_SERVER[ 'HTTP_HOST' ];
	$path = $_SERVER[ 'REQUEST_URI' ];
	$uri = $scheme . $host . $path;	// Alternative fiable à get_permalink() : fonctionnera partout sur le site
	$root = str_replace( 'index.php', '', $_SERVER[ 'SCRIPT_NAME' ] );
	$slug = str_replace( $root, '', $_SERVER[ 'REQUEST_URI' ] );
	$slug = explode( '/', $slug );

	$version = date( dmy ); // Versioning pour certains fichiers css et js

	$siteName = get_bloginfo( 'name' ); // Nom du site
	$siteUri = get_site_url(); // Url du site
    $siteLang = get_language_attributes();
	$templateUri = get_template_directory_uri(); // Emplacement du thème
	$imgDefault = $templateUri . '/Images/Default.jpg';

	global $current_user;

	$userLogin = $current_user->user_login;
	$userEmail = $current_user->user_email;
	$userLevel = $current_user->user_level;
	$userFirstName = $current_user->user_firstname;
	$userLastName = $current_user->user_lastname;
	$userDisplayName = $current_user->display_name;
	$userId = $current_user->ID;
	$capacityRead = current_user_can( 'read' );
	$capacityCommentator = ( current_user_can( 'subscriber' ) ) ? false : true;
	$capacityEditPosts = current_user_can( 'edit_posts' );

	global $gravatarUri;

	$userRegistrationOpen = get_option( 'scriptura_user_registration' );
	$userRegistrationMainNav = get_option( 'scriptura_user_registration_main_nav' );


	//var_dump($_SERVER['HTTPS']);die();