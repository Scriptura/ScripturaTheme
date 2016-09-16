<?php

// -----------------------------------------------------------------------------
// @section     MainNav
// @description Gestion de wp_nav_menu()
// -----------------------------------------------------------------------------

// @link https://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items

function ScripturaMainNav()
{

	global $uri;
	global $siteUri;
	global $gravatarUri;
	global $slug;
	global $userRegistrationMainNav;

	global $current_user;
	$userDisplayName = $current_user->display_name;

	// Paramétrage du menu principal
	$menu_name = 'primary';

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items( $menu->term_id );
		$menuList = PHP_EOL . '<ul>' . PHP_EOL;
		$menuList .= '<li>';
		if ( is_home() ) {
			$menuList .= '<span class="active">';
		} else {
			$menuList .= '<a href="' . $siteUri . '">';
		}
		$menuList .= '<span class="icon-home only-icon"></span><span>Home</span>';
		if ( is_home() ) {
			$menuList .= '</span>';
		} else {
			$menuList .= '</a>';
		}
		$menuList .= '</li>' . PHP_EOL;

		$arrayHttp = [ 'http://', 'https://' ];

		foreach ( ( array ) $menu_items as $key => $menu_item ) {
			$title = $menu_item->title;
			$tabUri = $menu_item->url;
			$tabUri = str_replace( $arrayHttp, '//', $tabUri );
			//var_dump( $tabUri );

			$class = $menu_item->classes[0];
			$testLink = ( $tabUri == $uri );

			$menuList .= '<li>';
			if ( $testLink ) {
				$menuList .= '<span class="active">';
			} else {
				$menuList .= '<a href="' . $tabUri . '">';
			}
			if ( $class ) {
				$menuList .= '<span class="' . $class . '"></span>';
			}
			$menuList .= $title;
			if ( $testLink ) {
				$menuList .= '</span>';
			} else {
				$menuList .= '</a>';
			}
			$menuList .= '</li>' . PHP_EOL;
		}
		if ( $userRegistrationMainNav ) {
			if ( is_user_logged_in() ) {
				$menuList .= '<li class="item-push login">';
				if ( count( $slug ) == 1 AND $slug[0] == 'Profile' ) {
					$menuList .= '<span class="active">';
				} else {
					$menuList .= '<a href="' . $siteUri . '/Profile">';
				}
				$menuList .= '<span class="icon-user"></span><span>' . $userDisplayName . '</span><div class="avatar" style="background-image:url(' . $gravatarUri . ')"></div>';
				if ( count( $slug ) == 1 AND $slug[0] == 'Profile' ) {
					$menuList .= '</span>';
				} else {
					$menuList .= '</a>';
				}
			} else {
			$menuList .= '<li class="item-push">';
				if ( count( $slug ) == 1 AND $slug[0] == 'Login' ) {
					$menuList .= '<span class="active">';
				} else {
					$menuList .= '<a href="' . $siteUri . '/Login">';
				}
				$menuList .= '<span class="icon-user"></span>' . __( 'Login', 'scriptura' );
				if ( count( $slug ) == 1 AND $slug[0] == 'Login' ) {
					$menuList .= '</span>';
				} else {
					$menuList .= '</a>';
				}
			}
		}
		$menuList .= '</li>' . PHP_EOL;
		$menuList .= '</ul>' . PHP_EOL;
	} else {
		$menuList = '<ul><li><span>[' . $menu_name . ' menu not defined - <a href="' . $siteUri . '/wp-admin/nav-menus.php">create a menu</a>]</span></li></ul>';
	}
	return $menuList;
}
$mainNav = ScripturaMainNav();

/*
$defaults = [
	'theme_location'  => '',
	'menu'            => 'primary',
	'container'       => false, // Paramètre obligatoire, sinon une div englobe le menu
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => '',
	'menu_id'         => '',
	'echo'            => false,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul>%3$s<ul>',
	'depth'           => -1, // Tous les onglets sur un seul niveau
	'walker'          => ''
];

// Enregistrement dans une variable
ob_start();
echo preg_replace( '#<li[^>]+>#', '<li>', wp_nav_menu( $defaults ) );
$mainNav = ob_get_contents();
ob_get_clean();

*/




