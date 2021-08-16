<?php
/**
 * Enqueue all the assets.
 *
 * @author ivanic
 */

namespace ShokkaForms;

class Assets {
    /**
     * Initialize assets.
     */
    public function init() {
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueueBlockEditorAssets' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueueFormPageAssets' ) );
    }

    /**
     * Enqueue block editor assets.
     */
    public function enqueueBlockEditorAssets() {
        wp_enqueue_script(
            'shokka-forms',
            plugins_url( 'js/dist/editor.js', 'shokka-forms/shokka-forms.php' ),
            array(
                'wp-blocks',
                'wp-element',
                'wp-i18n',
                'wp-block-editor',
                'wp-components',
            ),
            filemtime(
                sprintf(
                    '%s%s%s',
                    trailingslashit( WP_PLUGIN_DIR ),
                    plugin_dir_path( 'shokka-forms/shokka-forms.php' ),
                    wp_normalize_path( 'js/dist/editor.js' )
                )
            ),
            true
        );

        wp_set_script_translations( 'shokka-forms', 'shokka-forms' );

        /**
         * Enqueues editor style. Prevent Shokka Forms style from loading by passing false.
         *
         * @param boolean $enqeue defaults to true.
         */
        $enqueueStyle = apply_filters( 'shokka_forms_enqueue_style', true );
        if ( $enqueueStyle ) {
            $this->enqueueStyle();
        }
    }

    /**
     * Enqueue form page assets for frontend.
     */
    public function enqueueFormPageAssets() {
        if ( false === is_singular( 'sfform' ) ) {
            return;
        }

        wp_enqueue_script(
            'shokka-forms-front',
            plugins_url( 'js/dist/front.js', 'shokka-forms/shokka-forms.php' ),
            array( 'jquery' ),
            filemtime(
                sprintf(
                    '%s%s%s',
                    trailingslashit( WP_PLUGIN_DIR ),
                    plugin_dir_path( 'shokka-forms/shokka-forms.php' ),
                    wp_normalize_path( 'js/dist/front.js' )
                )
            ),
            true
        );

        wp_set_script_translations( 'shokka-forms-front', 'shokka-forms' );

        // Add only data that is ok to be cached!
        wp_add_inline_script(
            'shokka-forms-front',
            sprintf(
                ';ShokkaForms=window.ShokkaForms||{};ShokkaForms.ajaxurl="%s";',
                admin_url( 'admin-ajax.php' )
            ),
            'before'
        );

        /**
         * Enqueues frontend style. Prevent Shokka Forms style from loading by passing false.
         *
         * @param boolean $enqeue defaults to true.
         */
        $enqueueStyle = apply_filters( 'shokka_forms_enqueue_style_front', true );
        if ( $enqueueStyle ) {
            $this->enqueueStyle();
        }
    }

    /**
     * Enqueue universal style. Only use minimal css to not affect theme.
     */
    private function enqueueStyle() {
        wp_enqueue_style(
            'shokka-forms',
            plugins_url( 'css/dist/style.css', 'shokka-forms/shokka-forms.php' ),
            array(),
            filemtime(
                sprintf(
                    '%s%s%s',
                    trailingslashit( WP_PLUGIN_DIR ),
                    plugin_dir_path( 'shokka-forms/shokka-forms.php' ),
                    wp_normalize_path( 'css/dist/style.css' )
                )
            )
        );
    }
}
