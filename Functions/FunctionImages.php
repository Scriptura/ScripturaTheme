<?php

// -----------------------------------------------------------------------------
// @section     Function Images
// @description Gestion des images
// -----------------------------------------------------------------------------


// @subsection  Upload SVG Ready
// @description Autorise l'upload des SVG dans la bibliothèque medias
// -----------------------------------------------------------------------------

// @link http://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
// @note Il existe une failles de sécurité XML avec le format SVG, c'est pourquoi l'upload de ce format est réservé aux administrateurs
// @note Le SVG n'est pas appelé en natif mais via une balise <img>

if ( is_admin() AND $capacityAdministrator ) {
    function ScripturaUploadMimesSvgAdd( $mimes )
    {
        $mimes[ 'svg' ] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'ScripturaUploadMimesSvgAdd' );
}


// @subsection  Thumbnails
// @description Support des images
// -----------------------------------------------------------------------------

// @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
// @link https://codex.wordpress.org/Post_Thumbnails
// @link https://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
// @link https://developer.wordpress.org/reference/functions/add_image_size/

// @param set_post_thumbnail_size() : $width, $height, $crop
// @param add_image_size() : string $name, int $width, int $height, bool|array $crop = false

//var_dump( get_intermediate_image_sizes () ); // Obtenir les tailles d'image disponibles

function ScripturaImagesSizes()
{
	add_theme_support( 'post-thumbnails' ); // Activation du support "image à la une"
	set_post_thumbnail_size( 1000, 0, true ); // Définition de l'image par défaut
	$arrayImageSizes = [ 2000, 1500, 1000, 800, 600, 400, 300 ]; // Définitions des images
	foreach ( $arrayImageSizes as $value ) {
		add_image_size( 'image' . $value, $value, 0, true ); // Création des images
	}
	foreach ( $arrayImageSizes as $value ) {
		add_image_size( 'imagePortrait' . $value, $value / 1.8, $value, true ); // Création des images format portrait
	}
	foreach ( $arrayImageSizes as $value ) {
		add_image_size( 'imageSquare' . $value, $value, $value, true ); // Création des images format carré
	}
}
add_filter( 'after_setup_theme', 'ScripturaImagesSizes' );

function ScripturaAddImageSizeNamesChoose( $sizes )
{ // Déclaration des définitions personnalisés pour l'éditeur
	$addsizes = [
		'imagePortrait1000' => __( 'Portrait', 'scriptura' ),
		'imageSquare1000' => __( 'Squarre', 'scriptura' )
	];
	$newsizes = array_merge( $sizes, $addsizes );
	return $newsizes;
}
add_filter( 'image_size_names_choose', 'ScripturaAddImageSizeNamesChoose' );


// @subsection  Images Caption Shortcode
// @description Gestion des images via l'éditeur
// -----------------------------------------------------------------------------

// @link https://codex.wordpress.org/Plugin_API/Filter_Reference/img_caption_shortcode
// @link https://developer.wordpress.org/reference/functions/img_caption_shortcode/
// @link https://developer.wordpress.org/reference/functions/wp_get_attachment_image/
// @link https://developer.wordpress.org/reference/functions/wp_calculate_image_srcset/
// @link https://developer.wordpress.org/reference/functions/wp_get_attachment_image_srcset/
// @link https://developer.wordpress.org/reference/hooks/max_srcset_image_width/

if ( !is_admin() ) :

function ScripturaImgCaptionShortcode( $current_html, $attr, $content )
{ // Change le html autour des images, généré via shortcode par l'éditeur WordPress
    global $host;
    global $arrayHttp;
    extract( shortcode_atts(
    	[
    		'id' => '',
    		'align' => '',
    		'width' => '',
    		'caption' => ''
    	], $attr
    ) );
    if ( 1 > ( int ) $width || empty( $caption ) ) return $content;
    if ( $id ) $id = 'id="' . esc_attr( $id ) . '" ';
        $image = $content; // do_shortcode( $content )
        $html ='<figure ' . $id . 'class="figure-focus-thumbnail-' . esc_attr( $align ) . '">'
            . PHP_EOL
            . '<picture>'
            . PHP_EOL
            . str_replace(
                [ PHP_EOL . PHP_EOL, PHP_EOL . PHP_EOL, PHP_EOL . PHP_EOL ], // @todo Il existe certainement une méthode plus simple pour supprimer deux retours chariots...
                [ PHP_EOL, PHP_EOL, PHP_EOL ],
                /*
                preg_replace(
                    [
                        '/<.*w sizes.*>/', // Les balises <sources> contenant ce string sont supprimées
                        '/class=.* src/', // Suppression des classes sur l'image
                        '/(<img[^>]*>)(.*)/s' // Image après les éléments <source>, facultatif...
                    ],
                    [
                        '',
                        'src',
                        '$2$1'
                    ],
                    str_replace(
                		// @note On filtre l'image pour avoir une sortie html convenant à un élément <picture> :
                		// -> input: '<img>'
                		// -> output: '<source><img>'
                        // @todo À évaluer
                		[
                			' srcset',
                			'w, ',
                			' 2500w ',
                			' 2000w ',
                			' 1500w ',
                			' 1000w ',
                			' 800w ',
                			' 600w ',
                			' 400w ',
                            ' />',
                            '><',
                            'http://' . $host,
                            'https://' . $host
                		],
                		[
                			'><source srcset',
                			'w sizes="100vw"><source srcset="',
                			' 2500w media="(min-width: 2000px)" ',
                			' 2000w media="(min-width: 1500px)" ',
                			' 1500w media="(min-width: 1000px)" ',
                			' 1000w media="(min-width: 800px)" ',
                			' 800w media="(min-width: 600px)" ',
                			' 600w media="(min-width: 400px)" ',
                			' 400w media="(min-width: 300px)" ',
                            '>',
                            '>' . PHP_EOL . '<', // ">\x0A\x0D<"
                            '/',
                            '/'
                		],
                		$image // Image and srcset attributes
                    )
                )
                */
                str_replace( $arrayHttp, '//', $image )
            )
        	. PHP_EOL
        	. '</picture>'
            . PHP_EOL
        	. '<figcaption>' . $caption . '</figcaption>'
            . PHP_EOL
        	. '</figure>';
            //var_dump($arrayHttp);exit;
    return $html;
}
add_filter( 'img_caption_shortcode', 'ScripturaImgCaptionShortcode', 10, 3 );

endif; // admin


// @subsection  Images Sizes Attribute
// @description Redéfinition des valeurs de l'attribut srcset
// -----------------------------------------------------------------------------

// @link https://www.smashingmagazine.com/2015/12/responsive-images-in-wordpress-core/

function ScripturaAdjustImageSizesAttr( $sizes, $size )
{
   $sizes = '100vw';
   return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'ScripturaAdjustImageSizesAttr', 10 , 2 );

