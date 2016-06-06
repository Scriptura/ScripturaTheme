<?php

// -----------------------------------------------------------------------------
// @section     Functions Head
// @description Gestion du head
// -----------------------------------------------------------------------------

// @section     Meta head
// @description Gestion des metas dans le head
// -----------------------------------------------------------------------------

if ( !is_admin() ) :

function ScripturaCleanHead()
{
	remove_action( 'wp_head', 'wlwmanifest_link' );							// Lien xml permettant l'accès au site pour le logiciel Windows Live Writer
	remove_action( 'wp_head', 'feed_links', 2 );							// Flux RSS général (rel="alternate")
	remove_action( 'wp_head', 'feed_links_extra', 3 );                   	// Flux RSS complémentaire (rel="alternate")
	remove_action( 'wp_head', 'rsd_link' );									// Lien RSD (rel="EditURI")
//	remove_action( 'wp_head', 'index_rel_link' );							// Index du lien ?
//	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );				// Post parent
//	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );				// Départ du lien ?
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	// Articles suivants et précédents (rel='prev', rel='next')
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );				// URL raccourcie de la page
	remove_action( 'wp_head', 'wp_generator' );								// Donne la version de WP
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );				// Suppression du lien json nécessaire à l'api REST
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );		// Idem
//	global $wp_widget_factory;												// Style ajouté par le widget "Commentaires récents"
//	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ));
}

add_action( 'init', 'ScripturaCleanHead' );

endif; // admin

