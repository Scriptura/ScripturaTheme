<?php

// -----------------------------------------------------------------------------
// @section     Set All
// @description Configuration commune à plusieurs pages du site
// -----------------------------------------------------------------------------

	if ( is_active_sidebar( 'footer' ) ) {
		ob_start();
		dynamic_sidebar( 'footer' );
		$widgetFooter .= ob_get_clean();
	}

	$searchForm = ScripturaSearchForm();