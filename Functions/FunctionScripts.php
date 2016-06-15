<?php

// -----------------------------------------------------------------------------
// @section     Function Scripts
// @description Gestion des fichiers javascripts 
// -----------------------------------------------------------------------------

// @note Lib jQuery chargés via CDN arpès un test javascript, et non par le moyen proposé par WordPress en natif. Les scripts associées à jQuery ne doivent donc pas être dépendant de la présence de jQuery via enqueue scripts et doivent donc être inscrits en ligne.

if (is_admin()) {

	wp_enqueue_script('admin', get_template_directory_uri(). '/Scripts/Sources/Admin.js', '', $version, true);

} else {

	function ScripturaScripts()
	{

		global $version;

		wp_deregister_script( 'jquery' ); // Suppression des bibliothèques 'jquery-core' et 'jquery-migrate' proposées par défaut
		wp_deregister_script( 'wp-embed' ); // Suppression de REST
		wp_dequeue_script( 'wp-mediaelement' );
		wp_deregister_script( 'wp-mediaelement' );
		//wp_register_script('jquery', get_template_directory_uri() . '/Scripts/Vendors/JQuery.js', '', $version, true); // Lib jQuery
		//wp_register_script('scripts', get_template_directory_uri() . '/Public/Scripts/Main.js', array( 'jquery' ), $version, true); // @note 'array( 'jquery' )' permet de tester la présence de jQuery
		//wp_enqueue_script( 'jquery' );
		//wp_enqueue_script( 'scripts' );
	}
	add_action( 'wp_enqueue_scripts', 'ScripturaScripts' );

} // admin
