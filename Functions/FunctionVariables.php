<?php

// -----------------------------------------------------------------------------
// @section     Function Variables
// @description Variables globales pour le thème
// -----------------------------------------------------------------------------

	$scheme = '//'; // Compatibilité avec SSL
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
	$templateUri = str_replace( 'http:', '', get_template_directory_uri() ); // Racine du site en // pour compatibilité avec certificat SSL
	$imgDefault = $templateUri . '/Images/Default.jpg';
	$imgDefault300 = $templateUri . '/Images/Default300.jpg';
	$imgDefault1000 = $templateUri . '/Images/Default1000.jpg';
	$imgDefault1500 = $templateUri . '/Images/Default1500.jpg';
	$imgDefault2000 = $templateUri . '/Images/Default2000.jpg';
	$imageProtected = $templateUri . '/Images/Protected.jpg';
	$imageProtected300 = $templateUri . '/Images/Protected300.jpg';
	$imageProtected1000 = $templateUri . '/Images/Protected1000.jpg';
	$imageProtected1500 = $templateUri . '/Images/Protected1500.jpg';
	$imageProtected2000 = $templateUri . '/Images/Protected2000.jpg';

	global $current_user;
	get_currentuserinfo();

	$userId = $current_user->ID;
	$userLogin = $current_user->user_login;
	$userEmail = $current_user->user_email;
	$userLevel = $current_user->user_level;
	$userFirstName = $current_user->user_firstname;
	$userLastName = $current_user->user_lastname;
	$userDisplayName = $current_user->display_name;
	$userDescription = $current_user->description; //get_user_meta( $userId, 'description', true );
	$userGroup = get_user_meta( $userId, 'group', true );
	$capacityAdministrator = current_user_can( 'administrator' );
	$capacityRead = current_user_can( 'read' );
	$capacityCommentator = ( current_user_can( 'subscriber' ) ) ? false : true;
	$capacityEditPosts = current_user_can( 'edit_posts' );

	$userRole = $current_user->roles[ 0 ];
	// Traduction de `$userRole` si possible :
	if ( $userRole == 'administrator' )    $userRole = __( 'Administrator', 'scriptura' );
	if ( $userRole == 'role_moderator' )   $userRole = __( 'Moderator', 'scriptura' );
	if ( $userRole == 'role_editor' )      $userRole = __( 'Editor', 'scriptura' );
	if ( $userRole == 'role_contributor' ) $userRole = __( 'Contributor', 'scriptura' );
	if ( $userRole == 'role_author' )      $userRole = __( 'Author', 'scriptura' );
	if ( $userRole == 'role_student' )     $userRole = __( 'Student', 'scriptura' );
	if ( $userRole == 'role_commentator' ) $userRole = __( 'Commentator', 'scriptura' );
	if ( $userRole == 'subscriber' )       $userRole = __( 'Subscriber', 'scriptura' );

	$userRegistrationOpen = get_option( 'scriptura_user_registration' );
	$userRegistrationMainNav = get_option( 'scriptura_user_registration_main_nav' );
	$authorizedGroups = false; // Initialisation de la variable par défaut

	global $gravatarUri;

