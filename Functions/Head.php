<?php

// -----------------------------------------------------------------------------
// @section     Head
// @description Configuration des balises meta et link du head du site
// -----------------------------------------------------------------------------

    //$version = '?ver=' . $version;
    $version = ''; // Désactivation du versioning
    $separator = ' | ';
    $locality = get_option( 'scriptura_itemprop_address_locality' );
    $country = get_option( 'scriptura_itemprop_address_country' );

    echo '<meta charset="utf-8">' . PHP_EOL;

    // Title tag:
    echo '    <title>';
    if ( is_home() OR is_front_page() ) {
        echo $siteName;
    } elseif ( is_category() ) {
        echo single_cat_title( '', false ) . $separator . __( 'Category', 'scriptura' ) . $separator . $siteName;
    } elseif ( is_tag() ) {
        echo single_tag_title( '', false ) . $separator . __( 'Tag', 'scriptura' ) . $separator . $siteName;
    } elseif ( is_author() ) {
        echo $name . $separator . $siteName;
    } elseif ( is_search() ) {
            echo __( 'Search results for', 'scriptura' ) . ' "' . get_search_query() . '"' . $separator . $siteName;
    } elseif ( count($slug) == 1 AND $slug[0] == 'Login' ) {
        echo __( 'Login', 'scriptura' ) . $separator . $siteName;
    } elseif ( count($slug) == 1 AND $slug[0] == 'Register' ) {
        echo __( 'Register', 'scriptura' ) . $separator . $siteName;
    } elseif ( count($slug) == 1 AND $slug[0] == 'Profile' ) {
        echo __( 'Profile', 'scriptura' ) . $separator . $siteName;
    } else {
            echo strip_tags( get_the_title() ) . $separator . $siteName;
    }
    echo '</title>' . PHP_EOL;
    if ( $restrictedRead  OR $authorizedGroups ) {
    echo '    <meta name="robots" content="noindex">' . PHP_EOL;
    }
    // Meta Description tag:
    echo '    <meta name="description" content="';
    if ( $restrictedRead AND ! $capacityRead ) {
    echo __( 'Content on this page is protected.', 'scriptura' );
    } elseif ( is_404() ) {
    echo __( 'Page not found.', 'scriptura' );
    } elseif ( is_home() OR is_front_page() ) { // @note Si page statique à la place de la vraie page d'accueil
    echo get_bloginfo( 'description' );
    } elseif ( is_category() ) {
    echo __( 'Request for the category', 'scriptura' ) . ': ' . single_cat_title( '', false ) . '.';
    } elseif ( is_tag() ) {
    echo __( 'Request for the tag', 'scriptura' ) . ': ' . single_tag_title( '', false ) . '.';
    } else {
        $metaDescription = get_post_meta( $post->ID, 'metadescription', true );
        if ( $metaDescription ) {
            echo $metaDescription;
        } else {
            echo get_the_excerpt();
        }
    }
    echo '">' . PHP_EOL;

    echo '    <meta name="viewport" content="width=device-width initial-scale=1.0">' . PHP_EOL;
    if ( $locality ) {
        echo '    <meta name="geo.placename" content="' . $locality . '">' . PHP_EOL;
    }
    if ( $country ) {
        echo '    <meta name="geo.region" content="' . $country . '">' . PHP_EOL;
    }
    echo '    <meta name="theme-color" content="#ff6f7d">' . PHP_EOL; // @note Couleur dominante pour le thème @affected Androïd
    echo '    <link rel="shortcut icon" href="' . $templateUri . '/Images/favicon.ico">' . PHP_EOL;
    echo '    <link rel="icon" sizes="192x192" href="' . $templateUri . '/Images/favicon192.png">' . PHP_EOL; // @affected Androïd
    echo '    <link rel="stylesheet" href="' . $templateUri . '/Public/Styles/MainBlooming.css' . $version . '" media="screen">' . PHP_EOL;
    echo '    <link rel="stylesheet" href="' . $templateUri . '/Public/Styles/Print.css' . $version . '" media="print">' . PHP_EOL;
    //wp_head(); // API WordPress

