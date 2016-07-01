<?php

// -----------------------------------------------------------------------------
// @section     Function Pannel Identity
// @description Information sur le site
// -----------------------------------------------------------------------------

if ( is_admin() ) :

	function pannel_identity() {
		if( isset( $_POST[ 'pannel-update' ] ) ) {
			if( ! wp_verify_nonce( $_POST[ 'pannel_noncename' ], 'pannel-update' ) ) {
				die('Token non valide');
			}
			foreach ($_POST['option'] as $name => $value) {
				if( empty( $value ) ) {
					delete_option( $name ); // Supprimer les options vides de la table MySQL 'wp_options'
				} else {
					update_option( $name, stripcslashes( $value ) ); // Créer une option si valeur existante, supression des slashes $value pour l'envoi à la BDD
				}
			}
			echo '<div id="message" class="updated">';
      		echo '<p>' . __( 'Options saved successfully.', 'scriptura' ) . '</p>';
			echo '</div>';
		}
	?>
	<div class="wrap">
		<h2><?php _e( 'Site identity', 'scriptura' ); ?></h2>
		<form method="post" action="">
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Informations about the organization', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e( 'Title of insert', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_organization_title" name="option[scriptura_organization_title]" value="<?php echo get_option( 'scriptura_organization_title', '' ); ?>" class="regular-text" placeholder="ex : Mentions légales, Adresse">
							<p class="description"><?php _e( 'This field is required if you want to show the information on the site.', 'scriptura' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Name of the organization', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_name" name="option[scriptura_itemprop_name]" value="<?php echo get_option( 'scriptura_itemprop_name', '' ); ?>" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Address', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_street_address" name="option[scriptura_itemprop_street_address]" value="<?php echo get_option( 'scriptura_itemprop_street_address', '' ); ?>" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Postal code', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_postal_code" name="option[scriptura_itemprop_postal_code]" value="<?php echo get_option( 'scriptura_itemprop_postal_code', '' ); ?>" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Locality', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_address_locality" name="option[scriptura_itemprop_address_locality]" value="<?php echo get_option( 'scriptura_itemprop_address_locality', '' ); ?>" class="regular-text">
							<p class="description"><?php _e( 'This result will appear in a meta tag site.', 'scriptura' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Country', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_address_country" name="option[scriptura_itemprop_address_country]" value="<?php echo get_option( 'scriptura_itemprop_address_country', '' ); ?>" class="regular-text">
							<p class="description"><?php _e( 'This result will appear in a meta tag site.', 'scriptura' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Phone', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_telephone" name="option[scriptura_itemprop_telephone]" value="<?php echo get_option( 'scriptura_itemprop_telephone', '' ); ?>" placeholder="ex : 04 77 00 00 00" class="regular-text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Email', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_email" name="option[scriptura_itemprop_email]" value="<?php echo get_option( 'scriptura_itemprop_email', '' ); ?>" placeholder="ex : pseudo@gmail.com" class="regular-text">
							<p class="description">En raison du risque de spams cette option est déconseillée. Le <a href="<?php bloginfo( 'url' ); ?>/wp-admin/admin.php?page=scriptura-pannel-2">formulaire de contact</a> du site est une alternative à privilégier car il garantit la confidentialité.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php _e( 'Editorial manager', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_itemprop_member" name="option[scriptura_itemprop_member]" value="<?php echo get_option( 'scriptura_itemprop_member', '' ); ?>" class="regular-text">
						</td>
					</tr>
					<tr>
					<th scope="row">
							<label><?php _e( 'Date site creation', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_site_creation_date" name="option[scriptura_site_creation_date]" value="<?php echo get_option('scriptura_site_creation_date', ''); ?>" placeholder="ex : 15/06/2010" class="regular-text">
							<p class="description"><?php _e( 'Follow the format <code>dd/mm/yyyy</code>.', 'scriptura' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<table class="form-table">
			<h3><?php _e( 'Display in the footer', 'scriptura' ); ?></h3>
				<tbody>
					<tr>
						<th scope="row">
							<label for="scriptura_organization"><?php _e( 'View information about the organization', 'scriptura' ); ?></label>
						</th>
						<td>
						<select id="scriptura_organization" name="option[scriptura_organization]">
							<option value="0"<?php if( get_option( 'scriptura_organization' ) == 0 ) { echo ' selected="selected"'; } ?><?php if ( ! get_option( 'scriptura_organization' ) ) { echo ' selected="selected"'; } ?>><?php _e( 'No', 'scriptura' ); ?></option>
							<option value="1"<?php if( get_option( 'scriptura_organization' ) == 1 ) { echo ' selected="selected"'; } ?>><?php _e('Pages and articles', 'scriptura'); ?></option>
						</select>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<p class="submit">
				<input type="hidden" name="pannel_noncename" value="<?php echo wp_create_nonce( 'pannel-update' ); ?>">
				<input type="submit" name="pannel-update" class="button-primary autowidth" value="<?php _e( 'Save changes', 'scriptura' ); ?>">
			</p>
		</form>
	</div>
	<?php }

endif; // admin