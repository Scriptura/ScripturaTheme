<?php

// -----------------------------------------------------------------------------
// @section     Set Search
// @description Configuration pour la page des résultats de recherche
// -----------------------------------------------------------------------------

	ob_start();
	echo __( 'Request to', 'scriptura' ) . ': ' . get_search_query();
	$name = ob_get_clean();

	require_once locate_template( 'Functions/CategoryTagSearch.php' );
