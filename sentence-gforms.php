<?php
/**
 * Plugin Name:     Sentence Gforms
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     sentence-gforms
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Sentence_Gforms
 */

// Your code starts here.
if(!function_exists('debug')){
    function debug($val){
        error_log(print_r( $val, true ));
    }
}

define( 'GF_SENTENCE_FORM_ADDON_VERSION', '2.0' );
define( 'GF_SENTENCE_FORM_ADDON_URL', plugin_dir_url(__FILE__));
add_action( 'gform_loaded', array( 'GF_Sentence_AddOn_Bootstrap', 'load' ), 5 );
 
class GF_Sentence_AddOn_Bootstrap {
 
    public static function load() {
 
        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }
 
        require_once( 'sentence-addon.php' );
 
        GFAddOn::register( 'GFSentenceAddOn' );
    }
 
}
 
function gf_sentence_addon() {
    return GFSentenceAddOn::get_instance();
}


