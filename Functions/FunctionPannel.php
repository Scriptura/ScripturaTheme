<?php

// -----------------------------------------------------------------------------
// @section     Function Pannel
// @description Option de navigation pour le thème
// -----------------------------------------------------------------------------

// @link http://www.grafikart.fr/tutoriels/wordpress/option-panel-wordpress-358

if ( is_admin() ) :

function ScripturaPannel()
{
	add_menu_page(
		__( 'Configure theme', 'scriptura' ),	// Titre de la page
		'Scriptura',							// Titre de l'onglet
		'administrator',						// http://codex.wordpress.org/Roles_and_Capabilities
		'scriptura-pannel',						// Id du pannel
		'pannel_templates_options',				// Nom de la fonction
		null,									// Icône du menu par défaut ('dashicons-admin-generic')
		81										// Emplacement de l'onglet dans le menu
		);
	add_submenu_page(
		'scriptura-pannel',						// Onglet principal sur lequel le sous-menu se rapporte
		__( 'Identity', 'scriptura' ),			// Titre de la page
		__( 'Identity', 'scriptura' ),			// Titre de l'onglet
		'administrator',						// http://codex.wordpress.org/Roles_and_Capabilities
		'scriptura-pannel-identity',			// Id du pannel
		'pannel_identity'						// Nom de la fonction
		);
	add_submenu_page(
		'scriptura-pannel',
		__( 'Users', 'scriptura' ),
		__( 'Users', 'scriptura' ),
		'administrator',
		'scriptura-pannel-users',
		'pannel_users'
		);
	add_submenu_page(
		'scriptura-pannel',
		__( 'Forms', 'scriptura' ),
		__( 'Forms', 'scriptura' ),
		'administrator',
		'scriptura-pannel-forms',
		'pannel_forms'
		);
}
add_action( 'admin_menu', 'ScripturaPannel' ); 	// Ajout d'un onglet dans l'admin

endif; // admin
