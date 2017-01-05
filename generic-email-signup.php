<?php
/**
 * Generic Email Plugin
 *
 * @link              http://genericcorp.com
 * @since             1.0.0
 * @package           Generic_Email_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Generic Email Plugin
 * Plugin URI:        http://genericcorp.com/plugin
 * Description:       Synergizing consumer email acquisiton with the enterprise cloud... holisticly.
 * Version:           1.0.0
 * Author:            Generic Corp
 * Author URI:        http://genericcorp.com/generic_team
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       generic-email-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}


/**
 *  Enqueue Scripts and Styles for the front end
 *
 *  @since 1.0.0
 */
function generic_email_plugin_enqueue_scripts()
{
    wp_register_script('gep-front-main', plugins_url('assets/js/main.js', __FILE__), array( 'jquery' ), null, true);
    wp_register_style('gep-front-style', plugin_dir_url(__FILE__) . '/assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'generic_email_plugin_enqueue_scripts');


// Declare some globals for database
global $wpdb;
global $generic_email_plugin_version;
global $generic_email_plugin_table_name;
$generic_email_plugin_version = '1.0.0';
$generic_email_plugin_table_name =  $wpdb->prefix . 'generic_emails';

/**
 *  Initialize database table and add option indicating software version.
 *
 *  @since 1.0.0
 */
function generic_email_plugin_table_init()
{
    global $wpdb;
    global $generic_email_plugin_version;
    global $generic_email_plugin_table_name;

    $installed_ver = get_option('generic_email_plugin_version');

    // author alerts email addresses table
    $query =    "CREATE TABLE " . $generic_email_plugin_table_name . " (
		id bigint(11) NOT NULL AUTO_INCREMENT,
		email varchar(255) NOT NULL,
    secondary_optin boolean DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY id (id)
		);";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($query);

    update_option('generic_email_plugin_version', $generic_email_plugin_version);
}
register_activation_hook(__FILE__, 'generic_email_plugin_table_init');

/**
 *  Register AJAX Endpoint
 *
 *  @since 1.0.0
 */
function generic_email_ajax_email_submit()
{
    global $wpdb;
    global $book_apothecary_table_name;

    $data = json_decode($_POST['data'], true);

    $updated = $wpdb->insert($book_apothecary_table_name, array(
        "email" => sanitize_text_field($data['email']),
        "secondary_optin" => sanitize_text_field($data['secondary_optin']),
    ), array('%s', '%s'));

    if ($updated) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_generic_email_submit', 'generic_email_ajax_email_submit');
add_action('wp_ajax_nopriv_generic_email_submit', 'generic_email_ajax_email_submit');

/**
 *  Register shortcode and return HTML.
 *
 *  [ generic-email ]
 *  @since 1.0.0
 */
function generic_email_shortcode()
{
    // enqueue necessary scripts and styles
    wp_enqueue_script('gep-front-main');
    wp_enqueue_style('gep-front-style');

    // Load the widget template
    require_once(plugin_dir_path(__FILE__) . 'templates/email_widget.php');
}
add_shortcode('generic-email', 'generic_email_shortcode');
