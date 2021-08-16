<?php
/**
 * Initialize everything.
 *
 * @author ivanic
 */

namespace ShokkaForms;

class App {

    /**
     * Initialize plugin.
     */
    public function init() {
        $activated = get_option( 'blfs_activated' );

        if ( 'pending' === $activated ) {
            $activation = new Activation();
            $activation->processActivation();
        }

        add_action( 'init', array( $this, 'setUpCPTs' ) );

        add_filter( 'the_content', array( $this, 'addFormBody' ) );

        $ajax = new Ajax();
        $ajax->init();

        $assets = new Assets();
        $assets->init();

        $formProcessor = new FormProcessor();
        $formProcessor->init();
    }

    /**
     * Set up custom post types.
     */
    public function setUpCPTs() {
        register_post_type(
            'sfform',
            array(
                'public'              => true,
                'publicly_queryable'  => true,
                'show_in_rest'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'exclude_from_search' => true,
                'show_ui'             => true,
                'menu_icon'           => 'dashicons-feedback',
                'hierarchical'        => false,
                'has_archive'         => 'sfforms',
                'map_meta_cap'        => true,
                'description'         => 'Shokka Forms form is a form based on the block editor blocks.',

                'labels'              => array(
                    'name'                   => 'SF Forms',
                    'singular_name'          => 'SF Form',
                    'add_new_item'           => 'Add New Form',
                    'edit_item'              => 'Edit Form',
                    'new_item'               => 'New Form',
                    'view_item'              => 'View Form',
                    'view_items'             => 'View Forms',
                    'search_items'           => 'Search Forms',
                    'not_found'              => 'No forms found',
                    'all_items'              => 'All Forms',
                    'item_published'         => 'Form publicshed',
                    'item_reverted_to_draft' => 'Form reverted to draft',
                    'item_scheduled'         => 'Form scheduled',
                    'item_updated'           => 'Form updated',
                    'item_link'              => 'Form link',
                    'item_link_description'  => 'A link to a form',
                ),

                'supports'            => array(
                    'title',
                    'editor',
                ),
            )
        );
    }

    /**
     * Add form body to form CPTs.
     *
     * @param string $the_content Original post content.
     * @return string Original or modified content.
     */
    public function addFormBody( $the_content ) {
        if ( false === is_singular( 'sfform' ) ) {
            return $the_content;
        }

        global $post;

        $template = locate_template( 'shokka-forms/templates/form-body.php' );

        if ( empty( $template ) ) {
            $template = sprintf(
                '%s%s%s',
                trailingslashit( WP_PLUGIN_DIR ),
                plugin_dir_path( 'shokka-forms/shokka-forms.php' ),
                wp_normalize_path( 'src/templates/form-body.php' )
            );
        }

        $args = array(
            'action'  => admin_url( 'admin-post.php' ),
            'content' => $the_content,
            'nonce'   => wp_create_nonce( 'shokka-forms-submit' ),
            'formID'  => $post->ID,
        );

        ob_start();

        load_template( $template, true, $args );

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
