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
$name = $member->display_name; // $member->nickname
$memberFirstName = get_user_meta( $memberId, 'first_name', true );
$memberLastName = get_user_meta( $memberId, 'last_name', true );
$email = false;
$email = $member->user_email;
$memberGravatar = false;
$memberGravatar = scripturaUserAvatar( $member->user_email );
$memberAvatar = false;
$memberAvatar = get_the_author_meta( 'avatar', $memberId );
if ( $memberGravatar ) {
	$avataruser = $memberGravatar;	
}
if ( $memberAvatar ) {
	$avataruser = $memberAvatar;
}
$memberDescription = $member->user_description;
$adminMemberUri = $siteUri . '/wp-admin/user-edit.php?user_id=' . $memberId . '.php';
$memberUri = $member->user_url;
$memberGroup = get_user_meta( $memberId, 'group', true );

// BEGIJN TEST
// @todo Variables à paramètrer :
// END TEST

$memberInfoList = '';
if ( $capacityModerator )
	$memberInfoList .= '<p><span class="icon-ampersand"></span>&nbsp;&nbsp;' . __( 'Identifiant:', 'scriptura' ) . ' ' . $memberId . '</p>' . PHP_EOL;
if ( $capacityModerator )
	$memberInfoList .= '<p><span class="icon-at"></span>&nbsp;&nbsp;' . __( 'Email:', 'scriptura' ) . ' ' . $member->user_email . '</p>' . PHP_EOL;
if ( $memberFirstName )
	$memberInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'First Name:', 'scriptura' ) . ' ' . $memberFirstName . '</p>' . PHP_EOL;
if ( $memberLastName )
	$memberInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Last Name:', 'scriptura' ) . ' ' . $memberLastName . '</p>' . PHP_EOL;
$memberInfoList .= '<p><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Name:', 'scriptura' ) . ' ' . $member->user_nicename . '</p>' . PHP_EOL;
if ( $memberUri )
	$memberInfoList .= '<p class="onaline"><span class="icon-link"></span>&nbsp;&nbsp;' . __( 'External link:', 'scriptura' ) . ' <a href="' . $memberUri . '">' . $memberUri . '</a></p>' . PHP_EOL;
$memberInfoList .= '<p><span class="icon-badge"></span>&nbsp;&nbsp;' . __( 'Role:', 'scriptura' ) . ' ' . $member->roles[0] . '</p>' . PHP_EOL;
	if ( $memberGroup )
		$memberInfoList .= '<p><span class="icon-radio-unchecked"></span>&nbsp;&nbsp;' . __( 'Group:', 'scriptura' ) . ' ' . $memberGroup . '</p>';

$changeProfile = '<a href="' . $adminMemberUri . '"><span class="icon-user"></span>&nbsp;&nbsp;' . __( 'Change profil', 'scriptura' ) . '</a>';

//var_dump( $member->roles );exit;