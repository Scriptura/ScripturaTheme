<?php

	ob_start();
	echo __( 'Tag', 'scriptura' ) . ': ' . single_cat_title( '', false );
	$name = ob_get_clean();

	require_once locate_template( 'Functions/CategoryTagSearch.php' );

