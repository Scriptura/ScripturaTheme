<?php

// -----------------------------------------------------------------------------
// @section     Functions Pannel Forms
// @description Formulaire de contact
// -----------------------------------------------------------------------------

if (is_admin()) :

	function pannel_forms() {
		if(isset($_POST['pannel-update'])) {
			if(!wp_verify_nonce($_POST['pannel_noncename'], 'pannel-update')) {
				die('Token non valide');
			}
			foreach ($_POST['option'] as $name => $value) {
				if(empty($value)) {
					delete_option($name);			// Supprimer les options vides de la table MySQL 'wp_options'
				} else {
					update_option($name, $value);	// Créer une option si valeur existante
				}
			}
			echo '<div id="message" class="updated">';
			echo '<p>' . __( 'Options saved successfully.', 'scriptura' ) . '</p>';
			echo '</div>';
		}
	?>
	<div class="wrap">
		<h2><?php echo __( 'Contact Forms', 'scriptura' ); ?></h2>
		<form method="post" action="">
			<hr>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label><?php echo __( 'Address(s) email the contact form', 'scriptura' ); ?></label>
						</th>
						<td>
							<input type="text" id="scriptura_email_contact" name="option[scriptura_emails_contact]" value="<?php echo get_option('scriptura_emails_contact', ''); ?>" class="regular-text" placeholder="pseudo@mail.com">
							<p class="description"><?php echo __( 'The emails are beings separated by commas without spaces if you want to save many. The contact form ensures privacy: email will not appear clearly on the site. If the field is left blank the default will be the address of the first administrator.', 'scriptura' ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<p class="submit">
				<input type="hidden" name="pannel_noncename" value="<?php echo wp_create_nonce('pannel-update'); ?>">
				<input type="submit" name="pannel-update" class="button-primary autowidth" value="<?php echo __('Save changes', 'scriptura'); ?>">
			</p>
		</form>
	</div>
	<?php }

endif; // admin