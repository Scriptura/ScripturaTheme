<?php

// -----------------------------------------------------------------------------
// @section     Function Articles
// @description Configuration 
// -----------------------------------------------------------------------------


// @subsection  Additional Information
// @description Informations supplémentaires sur un article
// -----------------------------------------------------------------------------

// Ajout de métadonnées pour un article via des champs supplémentaires dans l'administration
// @link https://developer.wordpress.org/reference/functions/add_meta_box/
// @link https://developer.wordpress.org/reference/functions/add_meta_box/#div-comment-343
// @link https://wabeo.fr/jouons-avec-les-meta-boxes/

if ( is_admin() ) {

add_action( 'load-post.php', 'ScripturaMetaBox' );
add_action( 'load-post-new.php', 'ScripturaMetaBox' );

// Calls the class on the post edit screen.
function ScripturaMetaBox()
{
	new ClassScripturaMetaBox();
}

class ClassScripturaMetaBox
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
				__( 'Additional Informations', 'scriptura' ),
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
		if ( ! isset( $_POST[ 'myplugin_inner_custom_box_nonce' ] ) ) {
			return $post_id;
		}

		$nonce = $_POST[ 'myplugin_inner_custom_box_nonce' ];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST[ 'post_type' ] ) {
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
		$dataMetaDescription = $_POST[ 'scriptura_meta_description' ];
		$dataArticleDescription = $_POST[ 'scriptura_article_description' ];
		$dataRestrictedRead = sanitize_text_field( $_POST[ 'scriptura_restricted_read' ] );
		$dataAuthorizedGroups = sanitize_text_field( $_POST[ 'scriptura_authorized_groups' ] );
		$dataAuthorGivenName = sanitize_text_field( $_POST[ 'scriptura_author_given_name' ] );
		$dataAuthorFamilyName = sanitize_text_field( $_POST[ 'scriptura_author_family_name' ] );
		$dataDocumentName = sanitize_text_field( $_POST[ 'scriptura_document_name' ] );
		$dataArticleSource = sanitize_text_field( $_POST[ 'scriptura_article_source' ] );
		$dataDocumentTranslator = sanitize_text_field( $_POST[ 'scriptura_document_translator' ] );
		$dataAddressLocality = sanitize_text_field( $_POST[ 'scriptura_address_locality' ] );
		$dataDocumentPublisher = sanitize_text_field( $_POST[ 'scriptura_document_publisher' ] );
		$dataDateDocumentPublished = sanitize_text_field( $_POST[ 'scriptura_date_document_published' ] );

		// Update the meta field.
		update_post_meta( $post_id, 'metadescription', $dataMetaDescription );
		update_post_meta( $post_id, 'articledescription', $dataArticleDescription );
		update_post_meta( $post_id, 'restrictedread', $dataRestrictedRead );
		update_post_meta( $post_id, 'authorizedgroups', $dataAuthorizedGroups );
		update_post_meta( $post_id, 'authorgivenname', $dataAuthorGivenName );
		update_post_meta( $post_id, 'authorfamilyname', $dataAuthorFamilyName );
		update_post_meta( $post_id, 'documentname', $dataDocumentName );
		update_post_meta( $post_id, 'articlesource', $dataArticleSource );
		update_post_meta( $post_id, 'documenttranslator', $dataDocumentTranslator );
		update_post_meta( $post_id, 'addresslocality', $dataAddressLocality );
		update_post_meta( $post_id, 'documentpublisher', $dataDocumentPublisher );
		update_post_meta( $post_id, 'datedocumentpublished', $dataDateDocumentPublished );
}


	// Render Meta Box content.
	// @param WP_Post $post The post object.

	public function ScripturaMetaBoxForm( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		
		global $capacityEditor;

		// Use get_post_meta to retrieve an existing value from the database.
		$dataMetaDescription = get_post_meta( $post->ID, 'metadescription', true );
		$dataArticleDescription = get_post_meta( $post->ID, 'articledescription', true );
		$dataRestrictedRead = get_post_meta( $post->ID, 'restrictedread', true );
		$dataAuthorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );
		$dataAuthorGivenName = get_post_meta( $post->ID, 'authorgivenname', true );
		$dataAuthorFamilyName = get_post_meta( $post->ID, 'authorfamilyname', true );
		$dataDocumentName = get_post_meta( $post->ID, 'documentname', true );
		$dataArticleSource = get_post_meta( $post->ID, 'articlesource', true );
		$dataDocumentTranslator = get_post_meta( $post->ID, 'documenttranslator', true );
		$dataAddressLocality = get_post_meta( $post->ID, 'addresslocality', true );
		$dataDocumentPublisher = get_post_meta( $post->ID, 'documentpublisher', true );
		$dataDateDocumentPublished = get_post_meta( $post->ID, 'datedocumentpublished', true );
 
		// Display the form, using the current value.

		if ( $capacityEditor ) { ?>
			<h3><?php _e( 'Protection of Article', 'scriptura' ); ?></h3>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="scriptura_restricted_read"><?php _e( 'Restricted read', 'scriptura' ); ?></label>
					</th>
					<td>
						<select id="scriptura_restricted_read" name="scriptura_restricted_read">
							<option value=""<?php if( $dataRestrictedRead == '' ) { echo ' selected="selected"'; } ?>><?php _e( 'No', 'scriptura' ); ?></option>
							<option value="1"<?php if( $dataRestrictedRead == 1 ) { echo ' selected="selected"'; } ?>><?php _e( 'Yes', 'scriptura' ); ?></option>
						</select>
						<p class="description"><?php _e( 'Reading the article restricted to members online.', 'scriptura' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="scriptura_authorized_groups"><?php _e( 'Authorized Groups', 'scriptura' ); ?></label>
					</th>
					<td>
						<input type="text" id="scriptura_authorized_groups" name="scriptura_authorized_groups" value="<?php echo esc_attr( $dataAuthorizedGroups ); ?>" style="width:100%" placeholder="<?php _e( 'GroupA', 'scriptura' ); ?>" />
						<p class="description"><?php _e( 'No default restriction if the field is left blank.', 'scriptura' ); ?></p>
					</td>
				</tr>
			</table>
			<hr>
		<?php } ?>
		<h3><?php _e( 'Description of article', 'scriptura' ); ?></h3>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="scriptura_meta_description"><?php _e( 'Meta description tag', 'scriptura' ); ?></label>
				</th>
				<td>
					<textarea id="scriptura_meta_description" name="scriptura_meta_description" placeholder="<?php _e( 'A description...', 'scriptura' ); ?>" style="width:100%;min-height:5rem"><?php echo esc_attr( $dataMetaDescription ); ?></textarea>
					<p class="description"><?php _e( 'This should be an interesting alternative to the title should contain 100 to 255 characters. It will appear in a html tag dedicated to search engines and will replace the default item proposed extract in the presentation pages (categories, keywords ...).', 'scriptura' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_article_description"><?php _e( 'Presentation of article', 'scriptura' ); ?></label>
				</th>
				<td>
					<textarea id="scriptura_article_description" name="scriptura_article_description" placeholder="<?php _e( 'A description...', 'scriptura' ); ?>" style="width:100%;min-height:5rem"><?php echo esc_attr( $dataArticleDescription ); ?></textarea>
					<p class="description"><?php _e( 'A presentation of the article. Appears light on the page next to the article.', 'scriptura' ); ?></p>
				</td>
			</tr>
		</table>
		<hr>
		<h3><?php _e( 'Article Source', 'scriptura' ); ?></h3>
		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="scriptura_author_given_name"><?php _e( 'Given name', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_author_given_name" name="scriptura_author_given_name" value="<?php echo esc_attr( $dataAuthorGivenName ); ?>" style="width:100%" placeholder="<?php _e( 'Given name', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_author_family_name"><?php _e( 'Family name', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_author_family_name" name="scriptura_author_family_name" value="<?php echo esc_attr( $dataAuthorFamilyName ); ?>" style="width:100%" placeholder="<?php _e( 'Family name', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_document_name"><?php _e( 'Article Title', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_document_name" name="scriptura_document_name" value="<?php echo esc_attr( $dataDocumentName ); ?>" style="width:100%" placeholder="<?php _e( 'Book, Article...', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_article_source"><?php _e( 'References', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_article_source" name="scriptura_article_source" value="<?php echo esc_attr( $dataArticleSource ); ?>" style="width:100%" placeholder="<?php _e( 'Volume, page, chapter...', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_document_translator"><?php _e( 'Translator', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_document_translator" name="scriptura_document_translator" value="<?php echo esc_attr( $dataDocumentTranslator ); ?>" style="width:100%" placeholder="<?php _e( 'Translator', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_address_locality"><?php _e( 'Address Locality', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_address_locality" name="scriptura_address_locality" value="<?php echo esc_attr( $dataAddressLocality ); ?>" style="width:100%" placeholder="<?php _e( 'Paris', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_document_publisher"><?php _e( 'Publisher', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_document_publisher" name="scriptura_document_publisher" value="<?php echo esc_attr( $dataDocumentPublisher ); ?>" style="width:100%" placeholder="<?php _e( 'Publishing house', 'scriptura' ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="scriptura_date_document_published"><?php _e( 'Date Document Published', 'scriptura' ); ?></label>
				</th>
				<td>
					<input type="text" id="scriptura_date_document_published" name="scriptura_date_document_published" value="<?php echo esc_attr( $dataDateDocumentPublished ); ?>" style="width:100%" placeholder="<?php _e( '1974', 'scriptura' ); ?>" />
				</td>
			</tr>
		</table>
		<?php
	}
}

} else {

	function ScripturaReplaceContent( $content )
	{ // Remplacement du contenu généré par WordPress
		$search = [
			'<h2>',
			'<h3>',
			'<h4>',
			'<h5>'
		];
		$replace = [
			'<h2 class="h3 vmin">',
			'<h3 class="h4 vmin">',
			'<h4 class="h5 vmin">',
			'<h5 class="h6 vmin">'
		];
		$content = str_replace( $search, $replace, $content );
		return $content;
	}
	add_filter( 'the_content', 'ScripturaReplaceContent' );

}