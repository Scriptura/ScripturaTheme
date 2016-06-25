<?php

// -----------------------------------------------------------------------------
// @section     Functions Head
// @description Gestion du head
// -----------------------------------------------------------------------------

// @section     Meta head
// @description Gestion des metas dans le head
// -----------------------------------------------------------------------------

if ( !is_admin() ) :

function ScripturaCleanHead()
{
	remove_action( 'wp_head', 'wlwmanifest_link' );							// Lien xml permettant l'accès au site pour le logiciel Windows Live Writer
	remove_action( 'wp_head', 'feed_links', 2 );							// Flux RSS général (rel="alternate")
	remove_action( 'wp_head', 'feed_links_extra', 3 );                   	// Flux RSS complémentaire (rel="alternate")
	remove_action( 'wp_head', 'rsd_link' );									// Lien RSD (rel="EditURI")
//	remove_action( 'wp_head', 'index_rel_link' );							// Index du lien ?
//	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );				// Post parent
//	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );				// Départ du lien ?
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	// Articles suivants et précédents (rel='prev', rel='next')
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );				// URL raccourcie de la page
	remove_action( 'wp_head', 'wp_generator' );								// Donne la version de WP
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );				// Suppression du lien json nécessaire à l'api REST
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );		// Idem
//	global $wp_widget_factory;												// Style ajouté par le widget "Commentaires récents"
//	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ));
}

add_action( 'init', 'ScripturaCleanHead' );

endif; // admin


// -----------------------------------------------------------------------------
// @section     Description Box
// @description Ajout d'un champ récupérant la description de l'article
// -----------------------------------------------------------------------------

// @link https://developer.wordpress.org/reference/functions/add_meta_box/
// @link https://developer.wordpress.org/reference/functions/add_meta_box/#div-comment-343
// @link https://wabeo.fr/jouons-avec-les-meta-boxes/
 
if ( is_admin() ) {
    add_action( 'load-post.php', 'ScripturaCallSomeClass' );
    add_action( 'load-post-new.php', 'ScripturaCallSomeClass' );
}

// Calls the class on the post edit screen.
function ScripturaCallSomeClass()
{
    new someClass();
}

class someClass
{
 
    // Hook into the appropriate actions when the class is constructed.
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_action( 'save_post', [ $this, 'save' ] );
    }
 
    // Adds the meta box container.
    public function add_meta_box( $post_type ) {
        // Limit meta box to certain post types.
        $post_types = array( 'post', 'page' );
 
        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
                'some_meta_box_name',
                __( 'Some Meta Box Headline', 'textdomain' ),
                [ $this, 'ScripturaMetaBoxForm' ],
                $post_type,
                'advanced',
                'high'
            );
        }
    }
 
    // Save the meta when the post is saved.
    // @param int $post_id The ID of the post being saved.
    public function save( $post_id ) {
 
        // We need to verify this came from the our screen and with proper authorization, because save_post can be triggered at other times.
 
        // Check if our nonce is set.
        if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['myplugin_inner_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) ) {
            return $post_id;
        }
 
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
 
		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}
 
		// OK, it's safe for us to save the data now.
 
		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['scriptura_meta_description'] );
 
		// Update the meta field.
		update_post_meta( $post_id, 'metadescription', $mydata );
}


	// Render Meta Box content.
	// @param WP_Post $post The post object.

	public function ScripturaMetaBoxForm( $post ) {
 
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
 
		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, 'metadescription', true );
 
		// Display the form, using the current value.
		?>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="scriptura_meta_description"><?php _e( 'Description', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_meta_description" name="scriptura_meta_description" value="<?php echo esc_attr( $value ); ?>" size="25" style="width:100%" placeholder="<?php _e( '100-255 carcteres...', 'scriptura' ); ?>" />
				</td>
			</tr>
		</table>
		<?php
	}
}

