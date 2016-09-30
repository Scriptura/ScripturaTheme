<?php

// -----------------------------------------------------------------------------
// @section     Set Search
// @description Configuration pour la page des résultats de recherche
// -----------------------------------------------------------------------------

// @note Donner la même valeur de capacité pour les liens pointants vers ce template @see SetSingle.php
if ( ! $capacityEditor ) {
	wp_redirect( $siteUri . '/404.php' );
	exit;
}

$member = ( isset( $_GET[ 'author_name' ] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
$memberId = $member->ID;
$memberEmail = false;
$memberEmail = $member->user_email;
$name = $member->display_name; // $member->nickname
$memberFirstName = get_user_meta( $memberId, 'first_name', true );
$memberLastName = get_user_meta( $memberId, 'last_name', true );
$memberGravatar = false;
$memberGravatar = scripturaUserAvatar( $memberEmail );
$memberAvatar = false;
$memberAvatar = get_the_author_meta( 'avatar', $memberId );
if ( $memberGravatar )
	$avatarUser = $memberGravatar;
if ( $memberAvatar )
	$avatarUser = $memberAvatar;
$memberDescription = $member->user_description;
$memberUri = $member->user_url;
$memberRoles = $member->roles[0];
$memberGroup = get_user_meta( $memberId, 'group', true );
$memberLocation = get_user_meta( $memberId, 'location', true );
//var_dump();exit;

$adminMemberUri = $siteUri . '/wp-admin/user-edit.php?user_id=' . $memberId . '.php';

$memberInfoList = '';
if ( $capacityModerator )
	$memberInfoList .= '<p><span class="icon-ampersand"></span>&nbsp;&nbsp;' . __( 'Identifiant:', 'scriptura' ) . ' ' . $memberId . '</p>' . PHP_EOL;
if ( $capacityModerator AND $memberFirstName )
	$memberInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'First Name:', 'scriptura' ) . ' ' . $memberFirstName . '</p>' . PHP_EOL;
if ( $capacityModerator AND $memberLastName )
	$memberInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Last Name:', 'scriptura' ) . ' ' . $memberLastName . '</p>' . PHP_EOL;
if ( $capacityModerator )
	$memberInfoList .= '<p><span class="icon-at"></span>&nbsp;&nbsp;' . __( 'Email:', 'scriptura' ) . ' ' . $memberEmail . '</p>' . PHP_EOL;
if ( $memberUri )
	$memberInfoList .= '<p class="onaline"><span class="icon-link"></span>&nbsp;&nbsp;' . __( 'External link:', 'scriptura' ) . ' <a href="' . $memberUri . '">' . $memberUri . '</a></p>' . PHP_EOL;
$memberInfoList .= '<p><span class="icon-badge"></span>&nbsp;&nbsp;' . __( 'Role:', 'scriptura' ) . ' ' . $memberRoles . '</p>' . PHP_EOL;
	if ( $memberGroup )
		$memberInfoList .= '<p><span class="icon-radio-unchecked"></span>&nbsp;&nbsp;' . __( 'Group:', 'scriptura' ) . ' ' . $memberGroup . '</p>' . PHP_EOL;
if ( $capacityModerator AND $memberLocation )
	$memberInfoList .= '<p><span class="icon-location"></span>&nbsp;&nbsp;' . __( 'Location:', 'scriptura' ) . ' ' . $memberLocation . '</p>' . PHP_EOL;

$changeProfile = '<a href="' . $adminMemberUri . '"><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Change profil', 'scriptura' ) . '</a>' . PHP_EOL;

//var_dump( $member->roles );exit;