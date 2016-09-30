<?php

// -----------------------------------------------------------------------------
// @section     Function Users
// @description Gestion des utilisateurs
// -----------------------------------------------------------------------------


// -----------------------------------------------------------------------------
// @section     Remove Roles Users
// @description Suppression des rôles
// -----------------------------------------------------------------------------

function ScripturaRemoveRole()
{ // @note Suppression des rôles par défaut de WP, sauf celui d'administrateur
    remove_role( 'editor' );
    remove_role( 'author' );
    remove_role( 'contributor' );
    remove_role( 'subscriber' );

    // @note Suppression des rôles personnalisés
    // @note Afin que les modifications éventuelles de chacun de ces rôles soient effectifs, ceux-ci sont d'abord supprimés pour être ensuite réécris dans la bdd @todo Solution en test.
    remove_role( 'role_moderator' );
    remove_role( 'role_editor' );
    remove_role( 'role_author' );
    remove_role( 'role_contributor' );
    remove_role( 'role_student' );
    remove_role( 'role_subscriber' );
}
add_action( 'after_setup_theme', 'ScripturaRemoveRole' );


// -----------------------------------------------------------------------------
// @section     Add Roles Users
// @description Création de rôles personnalisés et gestion des droits
// -----------------------------------------------------------------------------

// @note Le rôle 'aministrator' est laissé en gérance à WordPress afin d'éviter les bugs éventuels sur une mise à jour

function ScripturaAddRole()
{
    add_role( 'role_moderator', __( 'Moderator', 'scriptura' ),
        [
            'delete_others_pages'        => true,
            'delete_others_posts'        => true,
            'delete_pages'               => true,
            'delete_posts'               => true,
            'delete_private_pages'       => true,
            'delete_private_posts'       => true,
            'delete_published_pages'     => true,
            'delete_published_posts'     => true,
            'edit_others_pages'          => true,
            'edit_others_posts'          => true,
            'edit_pages'                 => true,
            'edit_posts'                 => true,
            'edit_private_pages'         => true,
            'edit_private_posts'         => true,
            'edit_published_pages'       => true,
            'edit_published_posts'       => true,
            'manage_categories'          => true,
            'manage_links'               => true,
            'moderate_comments'          => true,
            'publish_pages'              => true,
            'publish_posts'              => true,
            'read'                       => true,
            'read_private_pages'         => true,
            'read_private_posts'         => true,
            'unfiltered_html'            => true,
            'upload_files'               => true
        ]
    );

    add_role( 'role_editor', __( 'Editor', 'scriptura' ),
        [
            'delete_others_pages'        => true,
            'delete_others_posts'        => true,
            'delete_pages'               => true,
            'delete_posts'               => true,
            'delete_private_pages'       => true,
            'delete_private_posts'       => true,
            'delete_published_pages'     => true,
            'delete_published_posts'     => true,
            'edit_others_pages'          => true,
            'edit_others_posts'          => true,
            'edit_pages'                 => true,
            'edit_posts'                 => true,
            'edit_private_pages'         => true,
            'edit_private_posts'         => true,
            'edit_published_pages'       => true,
            'edit_published_posts'       => true,
            'publish_pages'              => true,
            'publish_posts'              => true,
            'read'                       => true,
            'read_private_pages'         => true,
            'read_private_posts'         => true,
            'unfiltered_html'            => true,
            'upload_files'               => true
        ]
    );

    add_role( 'role_author', __( 'Author', 'scriptura' ),
        [
            'delete_posts'               => true,
            'delete_published_posts'     => true,
            'edit_posts'                 => true,
            'edit_published_posts'       => true,
            'publish_posts'              => true,
            'read'                       => true,
            'upload_files'               => true
        ]
    );

    add_role( 'role_contributor', __( 'Contributor', 'scriptura' ),
        [
            'delete_posts'               => true,
            'edit_posts'                 => true,
            'read'                       => true
        ]
    );

    add_role( 'role_student', __( 'Student', 'scriptura' ),
        [
            'edit_posts'                 => true,
            'edit_published_posts'       => true,
            'publish_posts'              => true,
            'read'                       => true,
            'edit_others_posts'          => true
            //'upload_files'               => true
        ]
    );

    add_role( 'role_commentator', __( 'Commentator', 'scriptura' ),
        [
            'read'                       => true
        ]
    ); // @note Se différencie de 'subscriber' sur la capacité à lire les commentaires

    add_role( 'subscriber', __( 'Subscriber', 'scriptura' ),
        [
            'read'                       => true
        ]
    );
}
add_action( 'after_setup_theme', 'ScripturaAddRole' );


// @subsection  Login User
// @description Connexion de l'utilisateur
// -----------------------------------------------------------------------------

// @note Fonctionnalitée d'autentification par mail
// @todo Désormais disponible par défaut dans WordPress ? À réévaluer...

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

function scripturaUserAvatar( $email = false, $size = 400 )
{
    if ( ! $email ) { // @note Email de l'utilisateur courant par défaut.
        global $userEmail;
        $email = $userEmail;
    }
    $default = 'mm'; // @param 'identicon'
    $uri = '//www.gravatar.com/avatar/' . md5( strtolower( trim( $email ) ) ) . '?d=' . urlencode( $default ) . '&s=' . $size;
    return $uri;
}
$avatarImg = scripturaUserAvatar();

endif; // admin


// @subsection  Restrict Access Administration
// @description Restreindre l’accès à l’administration à certains rôles
// -----------------------------------------------------------------------------

// @note Si une url de l'administration est appelée directement sans passer par une page du site alors page blanche, sinon retour à la page précédente.
// @link http://www.geekpress.fr/restreindre-administration-roles/
// @link https://codex.wordpress.org/Roles_and_Capabilities
// @todo Bloque l'utilisation d'Ajax en l'état, si besoin ajouter la condition suivante :
// @param `if ( ! current_user_can( 'edit_posts' ) AND ( !isset( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] ) OR $_SERVER[ 'HTTP_X_REQUESTED_WITH' ] != 'XMLHttpRequest' ) )`

function ScripturaRestrictAccessAdministration()
{
    if ( ! current_user_can( 'edit_posts' ) ) { // Si le rôle n'a pas la capacité 'edit_posts'
        wp_redirect( $_SERVER[ 'HTTP_REFERER' ] ); // Revient à la page précédente
        exit();
    }
}
add_action( 'admin_init', 'ScripturaRestrictAccessAdministration' );


// @subsection  Clear Dashboard
// @description Nettoyage des widgets par défaut
// -----------------------------------------------------------------------------

if ( is_admin() ) :

function ScripturaDashboard()
{
    remove_action( 'welcome_panel', 'wp_welcome_panel' ); // Widget de Bienvenue @note remove_action() et non remove_meta_box()
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' ); // Widget Brouillon rapide
    remove_meta_box( 'dashboard_primary', 'dashboard', 'core' ); // Widget Nouvelles de WordPress
}
add_action( 'admin_menu', 'ScripturaDashboard' );

endif; // admin


// @subsection  Light Administration
// @description Alègement de l'administration selon le rôle
// -----------------------------------------------------------------------------

// @note La suppression des onglets n'empêche pas l'accès direct à la page
// @link https://codex.wordpress.org/Function_Reference/remove_menu_page
// @link https://codex.wordpress.org/Function_Reference/remove_meta_box

if ( is_admin() ) :

if ( ! $capacityAdministrator ) {
    function ScripturaRemoveMenuIfNoAdministrator()
    {
        remove_menu_page( 'tools.php' );                               // Onglet "Outils" supprimé
        remove_menu_page( 'themes.php' );                              // Onglet "Apparence" supprimé
    }
    add_action( 'admin_menu', 'ScripturaRemoveMenuIfNoAdministrator' );
}

if ( ! $capacityModerator ) {
    function ScripturaRemoveMenuIfNoModerator()
    {
        remove_menu_page( 'edit-comments.php' );                       // Onglet "Commentaires" supprimé
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' ); // Widget "Coup d'œil" supprimé
        remove_meta_box( 'dashboard_activity', 'dashboard', 'core' );  // Widget "Activité" supprimé
    }
    add_action( 'admin_menu', 'ScripturaRemoveMenuIfNoModerator' );

    function ScripturaRemoveScreenOptions( $display_boolean, $wp_screen_object )
    {
        $blacklist = [ 'post.php', 'post-new.php', 'index.php', 'edit.php' ];
        if ( in_array( $GLOBALS[ 'pagenow' ], $blacklist ) ) {
            $wp_screen_object->render_screen_layout();
            $wp_screen_object->render_per_page_options();
            return false;                                              // Onglet "Option de l'écran" supprimé
        } else {
            return true;
        }
    }
    add_filter( 'screen_options_show_screen', 'ScripturaRemoveScreenOptions', 10, 2 );

    function ScriputraRemoveHelpTabs( $old_help, $screen_id, $screen )
    {
        $screen->remove_help_tabs();
        return $old_help;                                              // Onglet "Aide" supprimé
    }
    add_filter( 'contextual_help', 'ScriputraRemoveHelpTabs', 999, 3 );

    // @link http://wordpress.stackexchange.com/questions/170474/disable-html-text-tab-in-post-editor
    function my_editor_settings( $settings )
    {                                                                  // Onglet "Text" pour l'édition supprimé
        $settings['quicktags'] = false;
        return $settings;
    }
    add_filter('wp_editor_settings', 'my_editor_settings');

}

if ( ! $capacityEditor ) {
    function ScripturaRemoveMenuIfNoEditor()
    {
        remove_menu_page( 'edit.php' );                                // Onglet "Articles" supprimé
        remove_menu_page( 'edit.php?post_type=page' );                 // Onglet "Pages" supprimé
        remove_menu_page( 'profile.php' );                             // Onglet "Profil" supprimé
        remove_menu_page( 'upload.php' );                              // Onglet "Médias" supprimé
    }
    add_action( 'admin_menu', 'ScripturaRemoveMenuIfNoEditor' );
}

endif; // admin


// @subsection  User profile fields
// @description Metas supplémentaires pour le profil utlisateur
// -----------------------------------------------------------------------------

// @link http://b-website.com/ajouter-des-information-aux-profils-utilisateur-dans-wordpress/

function ScripturaUserAddMetas( $user )
{
    $avatar = get_the_author_meta( 'avatar', $user->ID );
    wp_enqueue_media(); // Permet l'upload des medias WP
    echo '<script>';
    echo '$templateUri = "' . get_bloginfo( 'template_directory' ) . '";'; // Variable javascript sur l'emplacement du thème, pour le bouton de suppression
    echo '</script>';

    ?>
    <h2><?php _e( 'Additional Information', 'scriptura' ); ?></h2>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label><?php _e( 'Location', 'scriptura' ); ?></label></th>
                <td><input class="regular-text" id="location" type="text" name="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" /></td>
            </tr>
            <tr>
                <th><label><?php _e( 'Group', 'scriptura' ); ?></label></th>
                <td><input class="regular-text" id="group" type="text" name="group" value="<?php echo esc_attr( get_the_author_meta( 'group', $user->ID ) ); ?>" /></td>
            </tr>
            <tr>
                <th><label><?php _e( 'Avatar', 'scriptura' ); ?></label></th>
                <td>
                    <div style="width:100%;height:100px;max-width:100px;max-height:100px;background:#333">
                        <img id="visual_scriptura_def_thumbnail" class="scriptura-media-visual" src="<?php if ( $avatar ) { echo $avatar; } else { echo get_template_directory_uri() . '/Images/Null.svg'; } ?>" style="display:block;max-width:100%;max-height:100%">
                    </div><br>
                    <input type="text" class="regular-text scriptura-media-link" id="avatar" name="avatar" value="<?php echo esc_attr( $avatar ); ?>" />
                    <a href="#" class="button scriptura-media-uploader"><?php _e( 'Choose an image', 'scriptura' ); ?></a>
                    <a href="#" class="button scriptura-media-remove"><?php _e( 'Delete image', 'scriptura' ); ?></a>
                    <p class="description"><?php _e( 'This presentation image will be used on the site preference to your gravatar if you have one. The image must be square.', 'scriptura' ); ?></p>
                </td>
            </tr>
        </tbody>
    </table>
<?php }
add_action( 'show_user_profile', 'ScripturaUserAddMetas' );
add_action( 'edit_user_profile', 'ScripturaUserAddMetas' );
 
 
function ScripturaUserSaveAddMetas( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        update_user_meta( $user_id, 'location', $_POST[ 'location' ] );
        update_user_meta( $user_id, 'group', $_POST[ 'group' ] );
        update_user_meta( $user_id, 'avatar', $_POST[ 'avatar' ] );
    }
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

