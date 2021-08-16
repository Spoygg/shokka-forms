<?php
/**
 * Clean up everything on uninstall.
 *
 * @author ivanic
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    wp_die(
        sprintf(
            // translators: %s - this file path.
            esc_html__( '%s should only be called when uninstalling the plugin.', 'shokka-forms' ),
            __FILE__
        )
    );
    exit;
}

$admin_role = get_role( 'administrator' );

if ( ! empty( $role ) ) {
    $admin_role->remove_cap( 'shokka_forms_manage' );
}

unregister_post_type( 'sfform' );
