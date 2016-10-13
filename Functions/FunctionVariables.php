<?php

// -----------------------------------------------------------------------------
// @section     Function Variables
// @description Variables globales pour le thème
// -----------------------------------------------------------------------------

	$arrayHttp = [ 'http://', 'https://' ];
	$scheme = '//'; // Pour compatibilité avec SSL
	$host = $_SERVER[ 'HTTP_HOST' ];
	$path = $_SERVER[ 'REQUEST_URI' ];
	$uri = $scheme . $host . $path;	// Alternative fiable à get_permalink() : fonctionnera partout sur le site
	$root = str_replace( 'index.php', '', $_SERVER[ 'SCRIPT_NAME' ] );
	$slug = str_replace( $root, '', $_SERVER[ 'REQUEST_URI' ] );
	$slug = explode( '/', $slug );

	$version = date( 'dmy' ); // Versioning pour certains fichiers css et js

	$siteName = get_bloginfo( 'name' ); // Nom du site
	$siteUri = str_replace( $arrayHttp, '//', get_site_url() ); // Url du site
	$siteLang = get_language_attributes();
	$templateUri = str_replace( $arrayHttp, '//', get_template_directory_uri() ); // Racine du site en // pour compatibilité avec certificat SSL
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
	$userUri = $current_user->user_url;
	$userFirstName = $current_user->user_firstname;
	$userLastName = $current_user->user_lastname;
	$userDisplayName = $current_user->display_name;
	$userDescription = $current_user->description; //get_user_meta( $userId, 'description', true );
	$userAvatar = get_user_meta( $userId, 'avatar', true );
	$userGroup = get_user_meta( $userId, 'group', true );
	$userLocation = get_user_meta( $userId, 'location', true );
	$capacityAdministrator = current_user_can( 'administrator' );
	$capacityModerator = current_user_can( 'moderate_comments' );
	$capacityEditor = current_user_can( 'unfiltered_html' );
	$capacityCommentator = ( current_user_can( 'subscriber' ) ) ? false : true; // @note Test d'une capacité et non du rôle par lui même 
	$capacityRead = current_user_can( 'read' );
	$capacityEditPages = current_user_can( 'edit_pages' );
	$capacityEditPosts = current_user_can( 'edit_posts' );

	if ( $userLogin ) // @note Évite une erreur de variable indéfinie si déconnexion
		$userRole = $current_user->roles[ 0 ];
	$userRegistrationOpen = get_option( 'scriptura_user_registration' );
	$userRegistrationMainNav = get_option( 'scriptura_user_registration_main_nav' );
	$restrictedRead = false;
	$authorizedGroups = ''; // Initialisation de la variable par défaut

	global $avatarImg; // @see FunctionUsers.php
    if ( $userAvatar )
        $avatarImg = $userAvatar;
    $avatarImg = str_replace( $arrayHttp, '//', $avatarImg );

