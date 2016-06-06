<?php

// -----------------------------------------------------------------------------
// @section     Function Pannel Users
// @description Option pour les utilisateurs
// -----------------------------------------------------------------------------

if (is_admin()) :

	function pannel_users() {
		if(isset($_POST['pannel-update'])) {
			if(!wp_verify_nonce($_POST['pannel_noncename'], 'pannel-update')) {
				die('Token non valide');
			}
			foreach ($_POST['option'] as $name => $value) {
				if(empty($value)) {
					delete_option($name);							// Supprimer les options vides de la table MySQL 'wp_options'
				} else {
					update_option($name, stripcslashes($value));	// Créer une option si valeur existante, supression des slashes $value pour l'envoi à la BDD
				}
			}
			echo '<div id="message" class="updated">';
      		echo '<p>' .__( 'Options saved successfully.', 'scriptura' ). '</p>';
			echo '</div>';
		}
	?>
	<div class="wrap">
		<h2><?php echo __( 'Users', 'scriptura' ); ?></h2>
		<form method="post" action="">
			<hr>
			<table class="form-table">
			<h3><?php echo __( 'User registration', 'scriptura' ); ?></h3>
				<tbody>
          			<tr>
            			<th scope="row">
              			<label><?php echo __( 'Allow user registration', 'scriptura' ); ?></label>
						</th>
						<td>
						<select id="scriptura_user_registration" name="option[scriptura_user_registration]">
							<option value=""<?php if(get_option('scriptura_user_registration') == '') { echo ' selected="selected"'; } ?><?php if (!get_option('scriptura_user_registration')) { echo ' selected="selected"'; } ?>><?php echo __( 'No', 'scriptura' ); ?></option>
							<option value="1"<?php if(get_option('scriptura_user_registration') == 1) { echo ' selected="selected"'; } ?>><?php echo __('Yes', 'scriptura'); ?></option>
						</select>
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