<?php
/**
 * Handle all ajax endpoints.
 *
 * @author ivanic
 */

namespace ShokkaForms;

class Ajax {
    /**
     * Initialize ajax.
     */
    public function init() {
        add_action( 'wp_ajax_shokka_forms', array( $this, 'ajaxGetVars' ) );
        add_action( 'wp_ajax_nopriv_shokka_forms', array( $this, 'ajaxGetVars' ) );
        add_action( 'wp_ajax_shokka_forms_get_errors', array( $this, 'ajaxGetFormErrors' ) );
        add_action( 'wp_ajax_nopriv_shokka_forms_get_errors', array( $this, 'ajaxGetFormErrors' ) );
    }

    /**
     * Generate Shokka Form data excluded from caching.
     */
    public function ajaxGetVars() {
        $data = array(
            'errorsNonce' => wp_create_nonce( 'shokka-forms-get-errors' ),
        );
        wp_send_json_success( $data );
    }

    /**
     * Retrieve form errors from db and send to user.
     */
    public function ajaxGetFormErrors() {
        if ( false === wp_verify_nonce( $_POST['nonce'], 'shokka-forms-get-errors' ) ) {
            wp_send_json_error(
                array(
                    'message' => 'Invalid nonce!',
                )
            );
        }

        $errorsID = sanitize_key( $_POST['sferr'] );

        $option = sprintf(
            'sf_%s',
            $errorsID
        );
        $errors = json_decode( get_transient( $option ) );

        wp_send_json_success(
            array(
                'errors' => $errors,
            )
        );
    }
}
