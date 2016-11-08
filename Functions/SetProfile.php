<?php

// -----------------------------------------------------------------------------
// @section     Set Profile
// @description Configuration pour la page de profil utlisateur
// -----------------------------------------------------------------------------

// @note Certaines fonctions WP ne peuvent être mise dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

// @documentation
// - 'ob_start()' enclenche la temporisation de sortie
// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface

// Vérification utilisateur connecté
$user = wp_get_current_user();
if ( $user->ID == 0 )
	header( 'location:Login' );

global $current_user;
$userDisplayName = $current_user->display_name;
//$name = __( 'Hello', 'scriptura' ) . ' ' . $userDisplayName;

$name = __( 'Your profile', 'scriptura' );

$logoutUri = wp_logout_url( '//' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] );
$adminUri = get_bloginfo( 'url' ) . '/wp-admin/';

$userInfoList = '';
$userInfoList .= '<p><span class="icon-ampersand"></span>&nbsp;&nbsp;' . __( 'ID:', 'scriptura' ) . ' ' . $userId . '</p>' . PHP_EOL;
$userInfoList .= '<p><span class="icon-ampersand"></span>&nbsp;&nbsp;' . __( 'Identifiant:', 'scriptura' ) . ' ' . $userLogin . '</p>' . PHP_EOL;
if ( $userDisplayName )
	$userInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Display Name:', 'scriptura' ) . ' ' . $userDisplayName . '</p>' . PHP_EOL;
if ( $userEmail )
	$userInfoList .= '<p><span class="icon-at"></span>&nbsp;&nbsp;' . __( 'Email:', 'scriptura' ) . ' ' . $userEmail . '</p>' . PHP_EOL;
if ( $userUri )
	$userInfoList .= '<p class="onaline"><span class="icon-link"></span>&nbsp;&nbsp;' . __( 'External link:', 'scriptura' ) . ' <a href="' . $userUri . '">' . $userUri . '</a></p>' . PHP_EOL;
if ( $userFirstName )
	$userInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'First Name:', 'scriptura' ) . ' ' . $userFirstName . '</p>' . PHP_EOL;
if ( $userLastName )
	$userInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Last Name:', 'scriptura' ) . ' ' . $userLastName . '</p>' . PHP_EOL;
if ( $userRole )
	$userInfoList .= '<p><span class="icon-badge"></span>&nbsp;&nbsp;' . __( 'Role:', 'scriptura' ) . ' ' . $userRole . '</p>' . PHP_EOL;
if ( $userGroups )
	$userInfoList .= '<p><span class="icon-radio-unchecked"></span>&nbsp;&nbsp;' . __( 'Group:', 'scriptura' ) . ' ' . $userGroups . '</p>' . PHP_EOL;
if ( $userLocation )
	$userInfoList .= '<p><span class="icon-location"></span>&nbsp;&nbsp;' . __( 'Location:', 'scriptura' ) . ' ' . $userLocation . '</p>' . PHP_EOL;

$loginLogout = '';
if ( $capacityModerator )
	$loginLogout .= '<a href="' . $adminUri . '"><span class="icon-login"></span>&nbsp;&nbsp;' . __( 'Administration', 'scriptura' ) . '</a>' . PHP_EOL;
$loginLogout .= '<a href="' . $logoutUri . '"><span class="icon-logout"></span>&nbsp;&nbsp;' . __( 'Logout', 'scriptura' ) . '</a>' . PHP_EOL;

