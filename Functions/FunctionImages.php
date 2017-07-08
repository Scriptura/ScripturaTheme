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
    $image = $content; // do_shortcode( $content )
    $idNumber = preg_replace( '/attachment_/', '', $id ); // On formate l'ID par défaut de WP
    if ( $idNumber ) $idDisplay = 'id="image' . esc_attr( $idNumber ) . '" ';
    // @warning : ´wp_upload_dir()['subdir']´ n'obtient que le dossier du mois en cours, pour obtenir le dossier courant de l'image il va falloir procéder par déduction (merci WordPress) :
    $imageMetadata = wp_get_attachment_metadata( $idNumber );
    $imageUrl = $imageMetadata['file'];
    $croup = strrpos( $imageUrl, '/', 0 ) + 1; // Repère le numéro de rang du dernier slash de la chaine
    $fileName = substr( $imageUrl, $croup );
    $folderUpload = str_replace( $fileName, '', $imageUrl ); // Dossier de l'image (enfin !)
    $imageSizes = $imageMetadata['sizes'];
    $uploadFiles = wp_upload_dir()['baseurl'] . '/'; // Dossier des uploads
    $uploadUrl = $uploadFiles . $folderUpload; // Url du dossier des uploads
    $image300Name = $imageMetadata['sizes']['image300']['file'];
    $image400Name = $imageMetadata['sizes']['image400']['file'];
    $image600Name = $imageMetadata['sizes']['image600']['file'];
    $image800Name = $imageMetadata['sizes']['image800']['file'];
    $image1000Name = $imageMetadata['sizes']['image1000']['file'];
    $image1500Name = $imageMetadata['sizes']['image1500']['file'];
    $image2000Name = $imageMetadata['sizes']['image2000']['file'];
    $image300Url = $uploadUrl . $image300Name;
    $image400Url = $uploadUrl . $image400Name;
    $image600Url = $uploadUrl . $image600Name;
    $image800Url = $uploadUrl . $image800Name;
    $image1000Url = $uploadUrl . $image1000Name;
    $image1500Url = $uploadUrl . $image1500Name;
    $image2000Url = $uploadUrl . $image2000Name;
    $sources = '';
    // @note Limitation en largeur, une source supplémentaire est générée via javascript pour le zoom
    //if ( $imageUrl )
    //  $sources .= '<source media="(min-width: 2000px)" srcset="' . $uploadFiles . $imageUrl . ' 2500w" sizes="100vw">' . PHP_EOL;
    //if ( $image2000Name )
    //  $sources .= '<source media="(min-width: 1500px)" srcset="' . $image2000Url . ' 2000w" sizes="100vw">' . PHP_EOL;
    //if ( $image1500Name )
    //  $sources .= '<source media="(min-width: 1000px)" srcset="' . $image1500Url . ' 1500w" sizes="100vw">' . PHP_EOL;
    //if ( $image1000Name )
    //  $sources .= '<source media="(min-width: 800px)" srcset="' . $image1000Url . ' 1000w" sizes="100vw">' . PHP_EOL;
    if ( $image800Name )
      $sources .= '<source media="(min-width: 600px)" srcset="' . $image800Url . ' 800w" sizes="100vw">' . PHP_EOL;
    if ( $image600Name )
      $sources .= '<source media="(min-width: 400px)" srcset="' . $image600Url . ' 600w" sizes="100vw">' . PHP_EOL;
    if ( $image400Name )
      $sources .= '<source media="(min-width: 300px)" srcset="' . $image400Url . ' 400w" sizes="100vw">' . PHP_EOL;
    if ( $image300Name )
      $sources .= '<source srcset="' . $image300Url . ' 300w" sizes="100vw">' . PHP_EOL;
    $html = '<figure ' . $idDisplay . 'class="figure-focus-thumbnail-' . esc_attr( $align ) . '">' . PHP_EOL
      . '<picture>' . PHP_EOL
      . $sources
      . '<img src="' . $uploadFiles . $imageUrl . '" alt="' . $caption . '">' . PHP_EOL // @link https://developer.wordpress.org/reference/functions/wp_upload_dir/
        . '</picture>' . PHP_EOL
        . '<figcaption>' . $caption . '</figcaption>' . PHP_EOL
        . '</figure>';
    $html = str_replace( $arrayHttp, '//', $html );
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


// @subsection  Gallery
// @description Redéfinition de la gallerie d'image native de WordPress
// -----------------------------------------------------------------------------

if (!is_admin()) :

// @note :
// fonctions désactivée :itemtag, icontag, captiontag (-> prise en charge html5)
// shortcode désactivé : [gallery link="file"] (-> caduc, car pris en charge par défaut par le script suivant)

function scriptura_post_gallery( $null, $attr = [] ) {
  global $post, $wp_locale;
  static $instance = 0;
  $instance++;
  // fonction "apply_filters" supprimée...
  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }
  extract( shortcode_atts( [
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
//  'itemtag'    => '',       // 'dl'
//  'icontag'    => '',       // 'dt'
//  'captiontag' => '',       // 'dd'
    'columns'    => 1,
    'size'       => 'full',   // thumbnail, medium, large, full, thumbnail1, thumbnail2
    'include'    => '',
    'exclude'    => ''
  ], $attr ) );
  
  $id = intval( $id );
  if ( 'RAND' == $order )
    $orderby = 'none';
 
  if ( !empty( $include ) ) {
    $include = preg_replace( '/[^0-9,]+/', '', $include );
    $_attachments = get_posts( [
      'include'        => $include,
      'post_status'    => 'inherit',
      'post_type'      => 'attachment',
      'post_mime_type' => 'image',
      'order'          => $order,
      'orderby'        => $orderby
      ] );

    $attachments = [];
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty( $exclude ) ) {
    $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
    $attachments = get_children( [
      'post_parent'    => $id,
      'exclude'        => $exclude,
      'post_status'    => 'inherit',
      'post_type'      => 'attachment',
      'post_mime_type' => 'image',
      'order'          => $order,
      'orderby'        => $orderby
      ] );
  } else {
    $attachments = get_children( [
      'post_parent'    => $id,
      'post_status'    => 'inherit',
      'post_type'      => 'attachment',
      'post_mime_type' => 'image',
      'order'          => $order,
      'orderby'        => $orderby
      ] );
  }
 
  if ( empty( $attachments ) )
    return '';
 
  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
    return $output;
  }
 
  $itemtag = tag_escape( $itemtag );
  $captiontag = tag_escape( $captiontag );
  $columns = intval( $columns );
  $itemwidth = $columns > 0 ? floor( 100/$columns ) : 100;
  $float = is_rtl() ? 'right' : 'left';
 
  $output = '<div id="gallery-' . $instance . '" class="gallery-jumble galleryid-' . $id . '">';

    foreach ( $attachments as $id => $attachment ) {
      $thumb = wp_get_attachment_image_src( $id, $size ); // We get the medium size image representing, it returns an array [url] [width] [height]
      $caption = wptexturize( $attachment->post_excerpt ); // The caption text
      if ( $caption ) {//si la description de l'image est renseignée
          $output .= '[caption id="attachment_' . $id . '" align="alignleft" width="' . $thumb[1] . '" caption="' . $caption . '"]'; // caption shortcode
        } else {//si l'image n'a pas de description
          $output .= '[caption id="attachment_' . $id . '" align="alignleft" width="' . $thumb[1] . '" caption="' . $caption . 'Description non renseignée."]';
        }
        $image = wp_get_attachment_image_src( $id, 'full' ); // We get the full size image representing, we'll use it to retrieve its url with $image[0]
        //$output .= '<a href="' . $image[0] . '">'; // lien sur $image[0] -> thumbnail, medium, large, full, miniature1, miniature2
        $output .= '<img class="attachment-' . $size . '" width="' . $thumb[1] . '" height="' . $thumb[2] . '" title="' . $caption . '" alt="' . $caption . '" src="' . $thumb[0] . '" />'; // The "thumbnail"
        //$output .= '</a>';
        $output .= '[/caption]';               // END caption shortcode
    }
    $output = do_shortcode( $output );         // We finally apply a do_shortcode for the... caption shortcodes

    $output .= '<br style="clear:both"></div>'; // Clear the thumbs floats and close the gallery div
 
  return $output;
}
add_filter( 'post_gallery', 'scriptura_post_gallery', 10, 2 );

endif; // admin