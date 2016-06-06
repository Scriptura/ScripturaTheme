<?php

    echo '<meta charset="utf-8">' . PHP_EOL;

    // Title tag:
    echo '    <title>';
    if ( is_tag() ) :
    wp_title( '' );
    echo ' | ' . __( 'Tag', 'scriptura' ) . ' | ' . get_bloginfo( 'name' );
    else :
    if ( is_search() ) :
    echo __( 'Search results for', 'scriptura' ) . ' "' . get_search_query() . '" | ';
    else :
    wp_title( '|', true, 'right' );
    endif;
    echo get_bloginfo( 'name' );
    endif;
    echo '</title>' . PHP_EOL;

    // Meta Description tag:
    if (is_home() OR is_front_page()) { // @note Si page statique à la place de la vraie page d'accueil
    echo '    <meta name="description" content="' .get_bloginfo('description'). '">' . PHP_EOL;
    } elseif (is_category()) {
    echo '    <meta name="description" content="' . __( 'Request for category:', 'scriptura') . single_cat_title("", false) . '.">' . PHP_EOL;
    } elseif (is_tag()) {
    echo '    <meta name="description" content="' . __( 'Request for tag:', 'scriptura') . single_tag_title("", false). '.">' . PHP_EOL;
    } else {
    if (get_post_meta($post->ID, 'metadescription', true)) : $metadescription = get_post_meta($post->ID, 'metadescription');
    echo '    <meta name="description" content="' . $metadescription[0] . '">' . PHP_EOL;
    endif;
    }

    echo '    <meta name="viewport", content="width=device-width, initial-scale=1.0">' . PHP_EOL;
    echo '    <meta name="geo.placename", content="LocalName, Loire, France">' . PHP_EOL;
    echo '    <link rel="shortcut icon" href="' . $templateUri . '/Images/favicon.svg">' . PHP_EOL;
    echo '    <link rel="stylesheet" href="' . $templateUri . '/Public/Styles/MainBlooming.css?ver=' . $version . '" type="text/css" media="screen">' . PHP_EOL;
    echo '    <link rel="stylesheet" href="' . $templateUri . '/Public/Styles/Print.css?ver=' . $version . '" type="text/css" media="print">' . PHP_EOL;


    //wp_head(); // API WordPress

