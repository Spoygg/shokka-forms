<?php
/**
 * Set up roles, CPTs and everything else needed for the plugin.
 *
 * @author ivanic
 */

namespace ShokkaForms;

use WP_Error;

class Activation {
    /**
     * Schedule activation on next page load, which is just after plugin activation.
     */
    public function activate() {
        add_option( 'blfs_activated', 'pending' );
    }

    /**
     * Execute all functions needed for the plugin set up.
     */
    public function processActivation() {
        add_action( 'init', array( $this, 'setUpRoles' ) );
        add_action( 'init', array( $this, 'setUpDB' ), 0 );

        update_option( 'blfs_activated', 'activated' );
    }

    /**
     * Set up needed roles.
     */
    public function setUpRoles() {
        $admin_role = get_role( 'administrator' );

        if ( ! empty( $admin_role ) ) {
            $admin_role->add_cap( 'shokka_forms_manage' );
        }
    }

    /**
     * Set up custom table(s) for saving form submissions.
     */
    public function setUpDB() {
        global $wpdb;

        $wpdb->shokka_forms_submissions = sprintf(
            '%s%s',
            $wpdb->prefix,
            'shokka_forms_submissions'
        );

        $schema_version = get_option( 'shokka_forms_db_version', 0 );

        if ( 1 !== intval( $schema_version ) ) {
            ob_start();
            include_once sprintf(
                '%s%s',
                plugin_dir_path( __FILE__ ),
                'schema_1.sql'
            );
            $sql = ob_get_contents();
            ob_end_clean();
            $sql = str_replace( 'tablename', $wpdb->shokka_forms_submissions, $sql );

            require_once sprintf(
                '%s%s',
                ABSPATH,
                wp_normalize_path( 'wp-admin/includes/upgrade.php' )
            );

            dbDelta( $sql );

            update_option( 'shokka_forms_db_version', 1 );
        }
    }
}
