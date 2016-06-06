<?php

// -----------------------------------------------------------------------------
// @subsection  Login User
// @description Connexion de l'utilisateur
// -----------------------------------------------------------------------------

// @note Fonctionnalitée désormait par défaut dans WordPress vanilla ? @todo À réévaluer...

function ScripturaAuthenticate( $user, $username, $password )
{
    if ( trim( $username ) != '' )
    $user = get_user_by_email( $username );
    if ( $user )
    $username = $user->user_login;
    return wp_authenticate_username_password( null, $username, $password );
}

remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 ); // Suppression du mode d'authentification par défaut de WordPress

add_filter( 'authenticate', 'ScripturaAuthenticate', 20, 3 );


// -----------------------------------------------------------------------------
// @subsection  Gravatars
// @description Affichage des gravatars
// -----------------------------------------------------------------------------

// @note Fonction plus fiable que get_avatar() de WordPress sur les pages autres que single.php
// @link https://fr.gravatar.com/site/implement/images/php/

if ( !is_admin() ) :

function scripturaUserGravatar()
{
    global $current_user;
    get_currentuserinfo();
    $email = $current_user->user_email;
    $default = 'identicon';
    $size = 200; // Taille maximum du gravatar
    $gravatarUri = '//www.gravatar.com/avatar/' . md5( strtolower( trim( $email ) ) ) . '?d=' . urlencode( $default ) . '&s=' . $size;
    return $gravatarUri;
}

$gravatarUri = scripturaUserGravatar();

endif; // admin
