<?php
/**
 * Wrapper class for Form CPT.
 */

namespace ShokkaForms;

class Form {
    /**
     * WP Post object that this class is wrapping.
     *
     * @var \WP_Post post.
     */
    private $post = null;

    /**
     * If form is validated.
     *
     * @var boolean validated.
     */
    private $validated = false;

    /**
     * If form is valid.
     *
     * @var boolean valid.
     */
    private $valid = true;

    /**
     * Errors from validation.
     *
     * @var array validation errors.
     */
    private $errors = array();

    /**
     * Construct the instance.
     *
     * @param \WP_Post $post Form CPT.
     */
    public function __construct( \WP_Post $post ) {
        $this->post = $post;
    }

    /**
     * Validates form. Call $form->isValid() to get the result.
     */
    public function validate() {
        $errors = array();

        $fields = $this->getFields();
        foreach ( $fields as $field ) {
            $name = $field['attrs']['name'];
            $type = $field['attrs']['type'] ?? 'text';
            // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $valid = $this->validateField( $_POST[ $name ], $type );
            if ( false === $valid ) {
                $errors[] = array(
                    'field'   => $field['attrs']['name'],
                    'message' => $this->getErrorMessage( $type ),
                );
            }
            // phpcs:endignore.
        }

        $this->errors    = $errors;
        $this->valid     = empty( $errors );
        $this->validated = true;
    }

    /**
     * Returns the form submitted data sanitized based on field type.
     *
     * @return array form data.
     */
    public function getData() {
        $data = array();

        $fields = $this->getFields();
        foreach ( $fields as $field ) {
            $name = $field['attrs']['name'];
            $type = $field['attrs']['type'] ?? 'text';
            // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $data[ $name ] = $this->sanitizeField( $_POST[ $name ], $type );
            // phpcs:endignore.
        }

        return $data;
    }

    /**
     * Get input fields from form post content.
     *
     * This method will return only the fields that
     * contain some data e.g. text field, select field.
     * Fields like buttons for submitting or clearing form
     * will not be included.
     *
     * @return array Data fields.
     */
    public function getFields() {
        $blocks = parse_blocks( $this->post->post_content );
        $fields = array_filter(
            $blocks,
            function( $block ) {
                if ( false === strpos( $block['blockName'], 'shokka-forms' ) ) {
                    return false;
                }

                if ( 'shokka-forms/button' === $block['blockName'] ) {
                    return false;
                }
                return true;
            }
        );

        return $fields;
    }

    /**
     * Check if form is valid.
     *
     * @return boolean is form valid.
     */
    public function isValid() {
        if ( false === $this->validated ) {
            $this->validate();
        }

        return $this->valid;
    }

    /**
     * Returns errors from validation.
     *
     * @return array Errors as field name => error.
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Sanitizes field data according to type format.
     *
     * @param mixed  $value Field value as submitted in the form.
     * @param string $type  Field type.
     *
     * @return mixed Sanitized data.
     */
    public function sanitizeField( $value, $type ) {
        if ( 'text' === $type ) {
            return sanitize_text_field( $value );
        }
        if ( 'email' === $type ) {
            return sanitize_email( $value );
        }
        if ( 'number' === $type ) {
            return intval( $value );
        }
        if ( 'tel' === $type ) {
            return preg_replace( '/[^\d+\(\)]/', '', $value );
        }
        if ( 'date' === $type ) {
            return strtotime( $value );
        }
        if ( 'time' === $type ) {
            return preg_replace( '/[^\d:]/', '', $value );
        }
    }

    /**
     * Validates field data according to type format.
     *
     * @param mixed  $value Field value as submitted in the form.
     * @param string $type  Field type.
     *
     * @return boolean field is in valid format.
     */
    public function validateField( $value, $type ) {
        if ( 'text' === $type ) {
            // Allow everything in text, it will be sanitized.
            return true;
        }
        if ( 'email' === $type ) {
            return false !== is_email( $value );
        }
        if ( 'number' === $type ) {
            return 1 === preg_match( '/^[0-9]+$/', $value );
        }
        if ( 'tel' === $type ) {
            return 1 === preg_match( '/^[\d+\(\)]+$/', $value );
        }
        if ( 'date' === $type ) {
            return false !== strtotime( $value );
        }
        if ( 'time' === $type ) {
            return 1 === preg_match( '/^\d+:\d+(:\d+)?$/', $value );
        }
    }

    /**
     * Return error message for specific field type.
     *
     * @param string $type  Field type.
     *
     * @return string error message.
     */
    public function getErrorMessage( $type ) {
        if ( 'text' === $type ) {
            return __( 'Text is not in a valid format.', 'shokka-forms' );
        }
        if ( 'email' === $type ) {
            return __( 'Email is not in a valid format.', 'shokka-forms' );
        }
        if ( 'number' === $type ) {
            return __( 'Number is not in a valid format.', 'shokka-forms' );
        }
        if ( 'tel' === $type ) {
            return __( 'Telephone number is not in a valid format.', 'shokka-forms' );
        }
        if ( 'date' === $type ) {
            return __( 'Date is not in a valid format.', 'shokka-forms' );
        }
        if ( 'time' === $type ) {
            return __( 'Time is not in a valid format.', 'shokka-forms' );
        }
    }
}
