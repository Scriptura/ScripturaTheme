<?php

// -----------------------------------------------------------------------------
// @section     Functions Search Form
// @description Alternative au formulaire de recherche par défaut de WordPress
// -----------------------------------------------------------------------------

function ScripturaSearchForm()
{
	$search = '<form role="search" method="get" action="' . get_site_url() . '">' // Attribut action pas nécessaire
			. '<fieldset class="search">'
			. '<input type="search" name="s" placeholder="' . __( 'Search', 'scriptura' ) . '" required/>'
			. '<label accesskey="s">' . __( 'Search', 'scriptura' ) . '</label>'
			. '<button><span>' . __( 'Submit', 'scriptura' ) . '</span></button>'
			//. wp_dropdown_categories() //recherche sur une catégorie @param 'show_option_all' = All catégories
			. '</fieldset>'
			. '</form>';
	return $search;
}
