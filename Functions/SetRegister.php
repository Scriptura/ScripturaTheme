<?php

// -----------------------------------------------------------------------------
// @section     Set Register
// @description Configuration pour la page d'inscription utlisateur
// -----------------------------------------------------------------------------

// @note Certaines fonctions WP ne peuvent être mise dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

// @documentation
// - 'ob_start()' enclenche la temporisation de sortie
// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface

	$name = __( 'Register', 'scriptura' );

	function ScripturaCreateUser()
	{
		global $recaptchaSiteKey;
		$name = $password = $email = '';
		$objMsg = '';
		$successMsg = '';
		if( isset( $_POST[ 'submitted' ] ) ) {
			if( trim( $_POST['registerName'] ) === '' ) {
				$nameError = __( 'Enter a username', 'scriptura' );
				$hasError = true;
			}
			$name = trim( $_POST[ 'registerName' ] );
			if( trim( $_POST[ 'password' ] ) === '' ) {
				$passwordError = __( 'Enter a password', 'scriptura' );
				$hasError = true;
			}
			if( strlen( trim( $_POST[ 'password' ] ) ) > 0 && strlen( trim( $_POST['password'] ) ) < 6) {
				$passwordError = __( 'The password is too short (Least 6 characters)', 'scriptura' );
				$hasError = true;
			}
			$password = trim( $_POST[ 'password' ] );
			if ( trim( $_POST[ 'email' ] ) !== '' && !preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST[ 'email' ] ) ) ) {
				$emailError = __('The email address is invalid', 'scriptura');
				$hasError = true;
			}
			if( trim( $_POST[ 'email' ] ) === '') {
				$nameError = __( 'Enter a email', 'scriptura' );
				$hasError = true;
			}
			$email = trim( $_POST[ 'email' ] );
			if( !isset( $hasError ) ) {
				$pwd = ( empty( $password ) ) ? wp_generate_password( $length = 7, false ) : $password;
				$user_id = wp_create_user( $name, $pwd, $email );
				if ( is_wp_error( $user_id ) )
						$objMsg = $user_id->get_error_message();
				else {
					$successMsg = __( 'User created', 'scriptura' );
					$successInfo = sprintf( __('<p>Username: <strong>%1s</strong></p><p>Password: <strong>%2s</strong></p><p>Email: <strong>%3s</strong></p>', 'scriptura' ), $name, $pwd, $email );
					$name = $password = $email = '';
				}
			}
			else {
				if ( isset( $nameError ) ) $objMsg .= $nameError. ' ';
				if ( isset( $passwordError ) ) $objMsg .= $passwordError. ' ';
				if ( isset( $emailError ) ) $objMsg .= $emailError;
			}
			unset( $_POST[ 'submitted' ] );
		}
		
		$msg = '';
		if ( !empty( $objMsg ) ) $msg = '<div><p class="message-error">' .$objMsg. '</p></div>';
		if ( !empty( $successMsg ) ) $msg = '<div><p class="message-success">' .$successMsg. '</p></div>';
		$msg2 = '';
		if ( !empty( $successInfo ) ) :
		$obj  = '<div class="list-stripe">';
		$obj .= $successInfo;
		$obj .= $msg2;
		$obj .= '<a href="' .get_bloginfo( 'url' ). '/Login"><span class="icon-pen"></span> ' .__( 'Sign in', 'scriptura' ). '</a>';
		$obj .= '</div>';
		else :
		$obj =
		$msg. '
		<form action="' .get_permalink(). '" method="post">
			<div class="input">
				<label for="registerName">' .__('Username', 'scriptura'). '</label>
				<input type="text" name="registerName" id="registerName" value="' .$name. '" placeholder="' .__( 'John Smith', 'scriptura' ). '" autocomplete="off" autofocus>
			</div>
			<div class="input-password">
				<label for="password">' .__('Password', 'scriptura'). '</label>
				<input type="password" name="password" id="password" value="' .$password. '" placeholder="• • • • • • • •" autocomplete="off">
				<input type="checkbox" title="See the password">
			</div>
			<div class="input">
				<label for="email">' .__( 'Email', 'scriptura' ). '</label>
				<input type="email" name="email" id="email" value="' .$email. '" placeholder="' .__( 'pseudo@gmail.com', 'scriptura' ). '" autocomplete="off">
			</div>'
			/*
			<div>
				<script src="https://www.google.com/recaptcha/api.js" async defer></script>
				<div class="g-recaptcha" data-sitekey="' .$recaptchaSiteKey. '"></div>
			</div>
			*/
			. '<div>
				<input type="hidden" name="submitted" id="submitted" value="true" />
				<button class="button"><span class="icon-checkmark"></span>&nbsp;&nbsp;' .__( 'Register', 'scriptura' ) . '</button>
			</div>
		</form>
		';
		endif;
		return $obj;
	}

    if ( $userRegistrationOpen ) {
		$content = ScripturaCreateUser();
    } else {
		$content = '<p class="message-error">' .__('The registration of new users is currently not allowed.', 'scriptura'). '</p>';
    }

	$message = __( 'The site moderation reserves the right to delete an account if the conditions of use are not respected.', 'scriptura' );

