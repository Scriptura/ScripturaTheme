<?php

// -----------------------------------------------------------------------------
// @section     Function Setup
// @description Gestion de fonctions WordPress
// -----------------------------------------------------------------------------

// @note Necessité de passer la fonction en lien avec after_setup_theme afin d'être enregistré avant l'initialisation du thème


function ScripturaSetup()
{


// @subsection Remove Admin Bar
// @description Suppression de la barre d'admin WP sur les pages front end
// -----------------------------------------------------------------------------

// @link https://codex.wordpress.org/Plugin_API/Filter_Reference/show_admin_bar
// @link https://codex.wordpress.org/Function_Reference/show_admin_bar
add_filter( 'show_admin_bar', '__return_false' ); // Retrait de la barre côté front end
//show_admin_bar( false ); // Alternative à la fonction précédente


// @subsection  Languages
// @description Externalisation du thème
// -----------------------------------------------------------------------------

// @note Fichiers d'externalisation pour les traductions du thème
// @note Nom de domaine et emplacement des fichiers de traduction
load_theme_textdomain( 'scriptura', get_template_directory() . '/Languages' );
//var_dump( get_locale() ); // @note Teste le paramètre de langue engresistré par l'utilisateur


// @subsection  RSS
// @description Ajoute des liens pour le flux RSS dans le head
// -----------------------------------------------------------------------------

add_theme_support( 'automatic-feed-links' );


// @subsection  Title tag
// @description Gestion du titre du head sans conflit avec les plugins SEO
// -----------------------------------------------------------------------------

//	add_theme_support( 'title-tag' );


// @subsection  Excerpt
// @description Gestion des extraits d'articles
// -----------------------------------------------------------------------------

if (!is_admin()) :

// Longueur des extraits d'article
function ScripturaExcerptLength() {
	return 60;
}
add_filter('excerpt_length', 'ScripturaExcerptLength');


// Pointillés pour les extraits de post
function ScripturaExcerptMore( $more ) {
	global $post;
	return '...';
}
add_filter('excerpt_more', 'ScripturaExcerptMore');

endif; // admin


// @subsection  Nav Menus
// @description Gestion de wp_nav_menu()
// -----------------------------------------------------------------------------

// Utilisation de wp_nav_menu() à deux emplacements dans le thème
register_nav_menus( [
	'primary' => __( 'Primary menu', 'scriptura' ),
	'secondary'  => __( 'Secondary menu', 'scriptura' ),
] );


// @subsection  Html5
// @description Balisage html5 par défaut pour certaines fonctionnalités WP
// -----------------------------------------------------------------------------

// @link https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5

add_theme_support( 'html5', [
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
] );


// @subsection  Do Shortcode
// @description Extention des shortcodes dans l'environnement WP
// -----------------------------------------------------------------------------

// Shortcodes dans les widgets
//add_filter( 'widget_text', 'do_shortcode' );

// Shortcodes dans les extraits d'articles
//add_filter( 'the_excerpt', 'do_shortcode' );

// Shortcodes dans les commentaires
// @note Attention aux injections Sql !
//add_filter( 'comment_text', 'do_shortcode' );


// @subsection  Post Formats
// @description Activation des Post Formats
// -----------------------------------------------------------------------------

// @link https://codex.wordpress.org/Post_Formats
add_theme_support( 'post-formats', [
	'aside',
	'image',
	'video',
	'quote',
	'link',
	'gallery',
	'status',
	'audio',
	'chat',
] );


// @subsection  Short Link
// @description Instaurer le bouton "Obtenir le lien court"
// -----------------------------------------------------------------------------

// @note Disponible dans l'éditeur des articles et pages

add_filter( 'get_shortlink', function( $shortlink ) {
	return $shortlink;
} );


// @subsection  Remove Pingbacks
// @description Suppression des rétroliens
// -----------------------------------------------------------------------------

// @note La méthode XMLRPC, gérant les rétroliens, est nécessaire pour utiliser JetPack, elle ne doit donc pas être complètement supprimée.
// @link https://github.com/fooplugins/remove-xmlrpc-pingback-ping/blob/master/remove-xmlrpc-pingback-ping.php
// @todo Méthode en test, ne semble pas fonctionner...

if ( ! defined( 'WPINC' ) ) {
	die;
}

function ScripturaRemoveXmlrpcPingbackPing( $methods )
{
	unset( $methods[ 'pingback.ping' ] );
	return $methods;
}
add_filter( 'xmlrpc_methods', 'ScripturaRemoveXmlrpcPingbackPing' );


// @subsection  Remove Emoji Icons
// @description Suppression des fichiers styles et js des émoticons par défaut
// -----------------------------------------------------------------------------

// @link https://wordpress.org/plugins/disable-emojis/

function ScripturaDisableEmojis()
{
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	//add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'ScripturaDisableEmojis' );

//function disable_emojis_tinymce( $plugins )
//{
//	if ( is_array( $plugins ) ) {
//		return array_diff( $plugins, array( 'wpemoji' ) );
//	} else {
//		return array();
//	}
//}


// END function ScripturaSetup :
}
add_action( 'after_setup_theme', 'ScripturaSetup' );

