<?php

// -----------------------------------------------------------------------------
// @section     Functions Search
// @description Personnalisation de la recherche de WordPress
// -----------------------------------------------------------------------------

function ScripturaExtendedSearch( $query )
{
	if ( ! is_admin() && $query->is_search ) {
		$query->set(
			'meta_query',
			[ 'relation' => 'AND',
				[
					'key'     => 'test',
					'value'   => like_escape( $query->query_vars[ 's' ] ),
					'compare' => 'LIKE'
				],
				[
					'key'     => 'test',
					'value'   => like_escape( $query->query_vars[ 's' ] ),
					'compare' => 'LIKE'
				]
			]
		);
	}
}
add_filter( 'pre_get_posts', 'ScripturaExtendedSearch' );
