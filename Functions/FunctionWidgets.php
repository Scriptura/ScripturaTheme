<?php

// -----------------------------------------------------------------------------
// @section     Function Widgets
// @description Gestion des widgets
// -----------------------------------------------------------------------------

// @subsection  Add Widgets
// @description Ajout de widgets
// -----------------------------------------------------------------------------

// @link https://codex.wordpress.org/Function_Reference/register_sidebar
// @link https://developer.wordpress.org/reference/functions/register_sidebar/

function ScripturaWidgetsInit ()
{
	register_sidebar (
		[
			'name' => 'Widget Footer',
			'id' => 'footer',
			'description' => __( 'This widget takes place in the site footer.', 'scriptura' ),
			'class' => 'test',
			'before_widget' => '<div>',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		]
	);
}
add_action ( 'widgets_init', 'ScripturaWidgetsInit' );


// @subsection  Remove Widget Title
// @description Suppression du titre si besoin
// -----------------------------------------------------------------------------

// @link https://fr.wordpress.org/plugins/remove-widget-titles/
// @note Si ajout de ! dans le champ du titre

function ScripturaRemoveWidgetTitle ( $widgetTitle )
{
	$test = substr ( $widgetTitle, 0, 1 );
	if ( $test == '!' )
		return;
	else
		return ( $widgetTitle );
}
add_filter( 'widget_title', 'ScripturaRemoveWidgetTitle' );

