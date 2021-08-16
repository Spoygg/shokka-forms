<?php
/**
 * Plugin Name: Shokka Forms
 * Plugin URI: http://spoygg.com/shokka-forms
 * Description: Create forms with the block editor, no extra learning required.
 * Text Domain: shokka-forms
 * Domain Path. /languages
 * Author: ivanic
 * Version: 0.0.1
 * Author URI: http://spoygg.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

require __DIR__ . '/vendor/autoload.php';

register_activation_hook(
    __FILE__,
    function() {
        $activation = new \ShokkaForms\Activation();
        $activation->activate();
    }
);

register_deactivation_hook(
    __FILE__,
    function() {
        $deactivation = new \ShokkaForms\Deactivation();
        $deactivation->deactivate();
    }
);

( function() {
    $shokka_forms = new \ShokkaForms\App();
    $shokka_forms->init();
} )();
