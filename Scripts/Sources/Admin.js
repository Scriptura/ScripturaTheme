// -----------------------------------------------------------------------------
// @name         Administration WP
// @description  Administration de WordPress
// -----------------------------------------------------------------------------

// @link http://www.grafikart.fr/tutoriels/wordpress/wp-media-uploader-403

(function( $ ) {
   $( '.scriptura-media-uploader' ).click( function( e ) {
      var $el = $( this ).parent();
      e.preventDefault();
      var uploader = wp.media({ // @note Le pannel admin personnalisé appele la classe php wp_enqueue_media() afin de pouvoir utiliser la classe js 'wp.media'
         title : 'Choisir une image de fond',
//         button : {
//            text : 'Selectionner'
//         },
         multiple : false
      } )
      .on( 'select', function() {
         var selection = uploader.state().get( 'selection' );
         var attachment = selection.first().toJSON();
         $( 'input', $el ).val(attachment.url);
         $( 'img', $el ).attr('src', attachment.url );
      } )
      .open();
   } );
} )( jQuery );

(function( $ ) { // Suppression de la miniature dans le visuel
   $( '.scriptura-media-remove' ).click(function( e ) {
      $( '#scriptura_def_thumbnail' ).val( '' );
      $( '#visual_scriptura_def_thumbnail' ).attr( 'src', $templateUri +'/Images/Null.svg' );
      e.preventDefault();
   } );
} )( jQuery );
