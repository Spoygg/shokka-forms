<?php
/**
 * Handles form submissions.
 *
 * @author ivanic
 */

namespace ShokkaForms;

class FormProcessor {
    /**
     * Initialized form processor.
     */
    public function init() {
        add_action( 'admin_post_shokka_forms_submit_form', array( $this, 'processFormSubmit' ) );
        add_action( 'admin_post_nopriv_shokka_forms_submit_form', array( $this, 'processFormSubmit' ) );
    }

    /**
     * Process form submission.
     */
    public function processFormSubmit() {
        if ( false === wp_verify_nonce( $_POST['shokka-forms-submit'], 'shokka-forms-submit' ) ) {
            status_header( 403 );
            exit( 'Action is not allowed!' );
        }

        $post = get_post( intval( $_POST['form_id'] ) );

        if ( is_null( $post ) ) {
            status_header( '404' );
            exit( 'Form not found!' );
        }

        $form = new Form( $post );
        if ( $form->isValid() ) {
            $this->saveForm( $form );
            wp_safe_redirect(
                sprintf(
                    '%s%s',
                    get_the_permalink( $post ),
                    '?sfmsg=success'
                )
            );
            exit;
        }

        $id = $this->setSessionErrors( $form );
        wp_safe_redirect(
            sprintf(
                '%s%s%s',
                get_the_permalink( $post ),
                '?sferr=',
                $id
            )
        );
        exit;
    }

    /**
     * Emulate session by saving errors to db.
     *
     * Do not use PHP session, remain stateless. Save errors
     * to options table and return option name as result.
     *
     * @param Form $form Form object.
     * @return string ID used to create option name in which errors are stored.
     */
    public function setSessionErrors( $form ) {
        $errors    = $form->getErrors();
        $id        = $this->generateID();
        $transient = sprintf(
            'sf_%s',
            $id
        );
        set_transient( $transient, wp_json_encode( $errors ), MINUTE_IN_SECONDS );
        return $id;
    }

    /**
     * Generate unique 6 character string.
     *
     * @return string Unique string.
     */
    private function generateID() {
        $u = uniqid();
        $o = random_int( 0, 6 );
        return substr( $u, $o, 6 );
    }

    /**
     * Save form data to custom table.
     *
     * @param Form $form form.
     */
    private function saveForm( Form $form ) {
        global $wpdb;

        $submissions_table = sprintf(
            '%s%s',
            $wpdb->prefix,
            'shokka_forms_submissions'
        );

        $data = array(
            'form_id'         => $form->ID,
            'submission_text' => wp_json_encode( $form->getData() ),
            'submission_date' => gmdate( 'Y-m-d H:i:s' ),
        );

        $format = array(
            '%d',
            '%s',
            '%s',
        );
        $wpdb->insert( $submissions_table, $data, $format );
    }

}
