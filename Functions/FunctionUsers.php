<?php

// -----------------------------------------------------------------------------
// @section     Function Users
// @description Gestion des utilisateurs
// -----------------------------------------------------------------------------

// @subsection  Login User
// @description Connexion de l'utilisateur
// -----------------------------------------------------------------------------

// @note Fonctionnalitée d'autentification par mail désormait disponible par défaut dans WordPress vanilla ? @todo À réévaluer...

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


// @subsection  Gravatars
// @description Affichage des gravatars
// -----------------------------------------------------------------------------

// @note Fonction plus fiable que get_avatar() de WordPress sur les pages autres que single.php
// @link https://fr.gravatar.com/site/implement/images/php/

if ( ! is_admin() ) :

function scripturaUserGravatar()
{
    global $current_user;
    //get_currentuserinfo();
    $email = $current_user->user_email;
    $default = 'identicon';
    $size = 400; // Taille maximum du gravatar
    $gravatarUri = '//www.gravatar.com/avatar/' . md5( strtolower( trim( $email ) ) ) . '?d=' . urlencode( $default ) . '&s=' . $size;
    return $gravatarUri;
}

$gravatarUri = scripturaUserGravatar();

endif; // admin

// @subsection  Restrict Access Administration
// @description Restreindre l’accès à l’administration à certains rôles
// -----------------------------------------------------------------------------

// @note Si une url de l'administration est appelée directement sans passer par une page du site alors page blanche, sinon retour à la page précédente.
// @link http://www.geekpress.fr/restreindre-administration-roles/
// @link https://codex.wordpress.org/Roles_and_Capabilities

function ScripturaRestrictAccessAdministration()
{
    if ( ! current_user_can( 'edit_posts' ) ) { // Si le rôle n'a pas la capacité 'edit_posts'
    // @todo Bloque l'utilisation de l'Ajax en l'état, si besoin utiliser ceci :
    //if ( ! current_user_can( 'edit_posts' ) AND ( !isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) OR $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] != 'XMLHttpRequest' )  ) { // Si besoin d'utiliser l'Ajax de l'admin par certains plugins...
        wp_redirect( $_SERVER['HTTP_REFERER'] ); // Revient à la page précédente
        exit();
    }
}
add_action( 'admin_init', 'ScripturaRestrictAccessAdministration' );


// @subsection  User profile fields
// @description Metas supplémentaires pour le profil utlisateur
// -----------------------------------------------------------------------------

function ScripturaUserAddMetas( $user )
{ ?>
 
    <h2><?php _e( 'Additional Information', 'scriptura' ); ?></h2>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label>Location</label></th>
                <td><input class="regular-text" id="location" type="text" name="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" /></td>
            </tr>
            <tr>
                <th><label>Group</label></th>
                <td><input class="regular-text" id="group" type="text" name="group" value="<?php echo esc_attr( get_the_author_meta( 'group', $user->ID ) ); ?>" /></td>
            </tr>
        </tbody>
    </table>
    
<?php }
add_action( 'show_user_profile', 'ScripturaUserAddMetas' );
add_action( 'edit_user_profile', 'ScripturaUserAddMetas' );
 
 
function ScripturaUserSaveAddMetas( $user_id ) {
 
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'location', $_POST[ 'location' ] );
    update_user_meta( $user_id, 'group', $_POST[ 'group' ] );
    
}
add_action( 'personal_options_update', 'ScripturaUserSaveAddMetas' );
add_action( 'edit_user_profile_update', 'ScripturaUserSaveAddMetas' );




// @subsection  Login WordPress
// @description Style particulier pour la page login de WordPress
// -----------------------------------------------------------------------------

/*
if ( !is_admin() ) :

// Annulation des styles par défaut
if ( basename( $_SERVER['PHP_SELF'] ) == 'wp-login.php' ) {
    add_action( 'style_loader_tag', create_function( '$a', 'return null;' ));
}

// Chemin de la nouvelle feuille de style
function scripturaCustomLogin() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'stylesheet_directory' ) . '/Public/Styles/MainRatatouille.css" />';
}
add_action( 'login_head', 'scripturaCustomLogin' );

// Lien par defaut de la page de connexion
function scripturaUrlLogin() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'scripturaUrlLogin' );

endif; // admin
*/

