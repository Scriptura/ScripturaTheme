<?php

// -----------------------------------------------------------------------------
// @section     Set Category
// @description Configuration pour les pages de catégories
// -----------------------------------------------------------------------------

	ob_start();
	echo single_cat_title( '', false );
	$name = ob_get_clean();

	require_once locate_template( 'Functions/CategoryTagSearch.php' );