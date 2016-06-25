<?php

// -----------------------------------------------------------------------------
// @section     Set Tag
// @description Configuration pour les pages de mots clefs
// -----------------------------------------------------------------------------

	ob_start();
	echo __( 'Tag', 'scriptura' ) . ': ' . single_cat_title( '', false );
	$name = ob_get_clean();

	require_once locate_template( 'Functions/CategoryTagSearch.php' );

