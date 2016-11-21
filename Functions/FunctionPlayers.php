<?php

// -----------------------------------------------------------------------------
// @section     Function Players
// @description Gestion des players audio et vidéo
// -----------------------------------------------------------------------------

// @subsection  Remove Media Element JS
// @description Suppression de l'appel aux scripts js et css liés à Media Element JS
// -----------------------------------------------------------------------------

// @note Le thème Scriptura propose une prise en charge personnalisée de Media Element JS, d'où la désacrivation de la PEC WordPress.
// @link https://premium.wpmudev.org/forums/topic/remove-mediaelement-js-css

function ScripturaNoMediaelement()
{
	return false;
}
add_filter( 'wp_video_shortcode_library','ScripturaNoMediaelement' );


// @subsection  Remove Media Element JS
// @description Suppression des éléments générés par WordPress
// -----------------------------------------------------------------------------

function ScripturaVideoShortcode( $content )
{
	$html = preg_replace( // Modification de la balise conteneur apposée par WordPress.
	'/<[^>]*>(.*?)<\/div>/',
	'<div itemprop="video">$1</div>', // On remplace les attributs par défaut de WordPress par de plus pertinents.
	$content
	);
	return $html;
}
add_filter( 'wp_video_shortcode', 'ScripturaVideoShortcode' );