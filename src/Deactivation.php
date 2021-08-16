<?php
/**
 * Carefully remove only generic plugin set up, do not delete user added
 * content. Plugin can be deactivated for many reasons, sometimes not by
 * the user.
 *
 * @author ivanic
 */

namespace ShokkaForms;

class Deactivation {
    /**
     * Execute functions for unsetting everything.
     */
    public function deactivate() {
        delete_option( 'blfs_activated' );
        $this->removeRoles();
    }

    /**
     * Unset roles.
     */
    public function removeRoles() {
        $admin_role = get_role( 'administrator' );

        if ( ! empty( $admin_role ) ) {
            $admin_role->remove_cap( 'shokka_forms_manage' );
        }
    }
}
