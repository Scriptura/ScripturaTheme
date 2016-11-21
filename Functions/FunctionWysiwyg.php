<?php

// -----------------------------------------------------------------------------
// @section     Function Wysiwyg
// @description Paramétrage de l'éditeur visuel tinyMCE
// -----------------------------------------------------------------------------

// @subsection  Add original buttons
// @description Ajout de boutons TinyMCE désactivé par défaut
// -----------------------------------------------------------------------------

// @documentation
// @link https://codex.wordpress.org/TinyMCE_Custom_Buttons
// @link http://archive.tinymce.com/wiki.php/TinyMCE3x:Buttons/controls

if ( is_admin() ) :

function ScripturaMceButtons2( $buttons )
{
    $buttons[] = 'superscript'; // @note 'sup'
    $buttons[] = 'subscript'; // @note 'sub'
    return $buttons;
}
add_filter( 'mce_buttons_2', 'ScripturaMceButtons2' );

function ScripturaMceButtons3( $buttons )
{
    $buttons[] = 'fontselect';
    $buttons[] = 'fontsizeselect';
    $buttons[] = 'styleselect';
    return $buttons;
}
add_filter( 'mce_buttons_3', 'ScripturaMceButtons3' );

endif; // admin


// -----------------------------------------------------------------------------
// @subsection  Wysiwyg extend buttons
// @description Extension des fonctionnalités de certaines boutons TinyMCE
// -----------------------------------------------------------------------------

if ( is_admin() ) :

// Choix étendu de la taille des polices
function ScripturaMceTextSizes( $obj )
{
    $obj[ 'fontsize_formats' ] = '.8em 1em 1.2em 1.4em 1.5em 1.6em 1.8em 2em 2.2em 2.5em 3em';
    return $obj;
}
add_filter( 'tiny_mce_before_init', 'ScripturaMceTextSizes' );

// Ajouter des polices personnalisées à la liste des polices
//function ScripturaMceFontsArray( $initArray )
//{
//    $initArray[ 'font_formats' ] .= 'Lato=Lato;Andale Mono=andale mono,times';
//    return $initArray;
//}
//add_filter( 'tiny_mce_before_init', 'ScripturaMceFontsArray' );

endif; // admin

// -----------------------------------------------------------------------------
// @subsection  Wysiwyg Styles
// @description Styles injecté dans la fenêtre wysiwyg
// -----------------------------------------------------------------------------

// @todo à mettre en place si besoin
// @link http://www.gregoirenoyelle.com/wordpress-accorder-style-editeur-wysiwyg-theme/

//  if ( is_admin() ) :
//  function styles_editeur_add()
//{
//      add_editor_style( 'css/editor-style.css' );
//  }
//  add_action( 'init', 'styles_editeur_add' );
//  endif; // admin

