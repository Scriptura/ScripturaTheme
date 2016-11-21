<?php

// -----------------------------------------------------------------------------
// @section     Set 404
// @description Configuration pour la page d'erreur 404
// -----------------------------------------------------------------------------

	$name = __( 'Error 404!', 'scriptura' );
	$content = __( 'Page not found...', 'scriptura' );
	$alternativeLink = __( 'Home Page', 'scriptura' );

	ob_start();
	echo ScripturaSearchForm();
	$searchForm = ob_get_clean();