<?php
/**
* Plugin Name: Pieeye: GDPR+CPRA+Cookie Consent+DSR
* Plugin URI: https://pii.ai/
* Description: PieEye simplifies GDPR/CPRA compliance with Cookie Consent and Data Subject Request Management. The Cookie Manager lets you customise the Cookie Banner and control which cookies are deployed. Consent events provide real-time updates on user preferences. IN ADDITION, the PieEye App automates the DSR process, creating a portal for shoppers to submit a DSR, verified identity, connects to any data sources in addition to Wordpress (like WooCommerce), and gives quick responses to customers within the required time frame. All of it automated. Note: By activating this plugin, you are opting in to the use of your domain name for functionality purposes. This information is used to interact with our app and enhance your experience. Your privacy is important to us, and we adhere to strict data protection measures to safeguard your information. For more details, please refer to our privacy policy.
* Version: 1.0.0
* Author: PieEye Inc
* Author URI: https://pii.ai/
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
**/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// define global variables used in the plugin
define('PIEEYE_CONF_API', 'https://wordpress.pii.ai');


// Register and enqueue the styles and scripts for plugin
function pieeye_add_assets($hook){
    if ( 'toplevel_page_pieeye-cookie' != $hook ) {
        return;
    }
    wp_register_style( 'pieeye_style', plugin_dir_url( __FILE__ ) . '/assets/css/pieeye-styles.css' );
    wp_enqueue_style( 'pieeye_style' );
    wp_register_script('pieeye-toggle-switch', plugins_url('/assets/js/toggleSwitch.js', __FILE__), array('jquery'), true);
    wp_enqueue_script('pieeye-toggle-switch');
}

add_action('admin_enqueue_scripts', 'pieeye_add_assets');


// function to update user consent or add new if first time visit
function pieeye_update_consent() {
    $consent_exists = get_option('pieeye_optin_consent');
    if (isset($_POST['option_value'])) {
        $option_value = sanitize_text_field($_POST['option_value']);
        if($option_value == "false"){
            // call deactivate hook when consent opted out
            $pieeye_consent_optout = pieeye_plugin_deactivation();
        }
        if($consent_exists == false){
            add_option('pieeye_optin_consent', $option_value);
        } else {
            update_option('pieeye_optin_consent', $option_value);
        }
        if($option_value == "true"){
            // call activate hook when consent opted in
            $pieeye_consent_optin = pieeye_plug_activate();
        }
        return $consent_exists;
    }
    wp_die();
}
  
add_action('wp_ajax_pieeye_update_consent', 'pieeye_update_consent');
add_action('wp_ajax_nopriv_pieeye_update_consent', 'pieeye_update_consent');

// Hook to add Plugin in the side menu of WordPress
add_action( 'admin_menu', 'pieeye_plugin_menu' );

function pieeye_plugin_menu() {
    add_menu_page( 
        'PieEye Cookie + DSR', // The text to display on the menu link
        'PieEye Cookie + DSR', // The text to display in the menu
        'manage_options', // The minimum user capability required to access this menu item
        'pieeye-cookie', // The unique ID of the menu item
        'pieeye_include_dashboard', // The function to call when the menu item is clicked
        'dashicons-visibility',
        null
    );
    
}

// function to include dashboard page in the plugin
function pieeye_include_dashboard(){
    include "dashboard.php";
}

// Filter to add a custom link in the plugins page list, to directly redirect to the plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'pieeye_dashboard_link', 10, 2);

function pieeye_dashboard_link($links, $file){
    $dashboard_link = "<a href='" . admin_url('admin.php?page=pieeye-cookie') . "'>Dashboard</a>";
    array_unshift($links, $dashboard_link);
    return $links;
}

function pieeye_plug_activate(){
    $pieeye_consent = get_option('pieeye_optin_consent', false);
    if($pieeye_consent == "true"){
        $url = get_site_url();
        $body = array(
            'site' => $url,
        );
        $header = array(
            'Content-Type' => 'application/json',
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => 45,
            'headers'     => $header,
            'body'        => json_encode($body),
            'cookies'     => array(),
        );
        $response = wp_remote_post(PIEEYE_CONF_API . '/site-exists', $args);
        set_transient('pieeye_banner_script_inserted_' . $url,  false, 2147483647);
    }
}

register_activation_hook(__FILE__, 'pieeye_plug_activate');

// Script hook to call javascript file to add banner script in the frontend of the site
// add_option('script_inserted', false);


add_action('wp_enqueue_scripts', 'pieeye_banner_script', 0);


// function to make an API call to wordpress to fetch banner script and inject in front end of site
function pieeye_banner_script(){
    $pieeye_consent = get_option('pieeye_optin_consent', false);
    if($pieeye_consent == "true"){
        $host = get_site_url();
        $script = get_transient('pieeye_banner_script_inserted_' . $host);
        if(!$script){
            $url = get_site_url();
            $body = array(
                'site' => $url,
            );
            $header = array(
                'Content-Type' => 'application/json',
            );
            $args = array(
                'method'      => 'POST',
                'timeout'     => 45,
                'headers'     => $header,
                'body'        => json_encode($body),
                'cookies'     => array(),
            );
            $response = wp_remote_post(PIEEYE_CONF_API . '/script', $args);
            $res_body = wp_remote_retrieve_body($response);
            // Decode the JSON response
            $json = json_decode($res_body); // decode the body in json format
            if(!isset($json->message)){
                // Call the javascript function to send the script in args to inject on front end of site and save in cache
                wp_register_script('pieeye-banner', plugins_url('/assets/js/cmsInstall.js', __FILE__), array('jquery'), true);
                wp_enqueue_script('pieeye-banner');
                wp_localize_script('pieeye-banner', 'banner', array('script' => $res_body));
                set_transient('pieeye_banner_script_inserted_' . $host,  $res_body, 2147483647);
            }
        }
    
        if ($script){
            wp_register_script('pieeye-banner', plugins_url('/assets/js/cmsInstall.js', __FILE__), array('jquery'), true);
            wp_enqueue_script('pieeye-banner');
            wp_localize_script('pieeye-banner', 'banner', array('script' => $script));
        }
    }
}



// hook to call wordpress bff on plugin deactivate
register_deactivation_hook( __FILE__, 'pieeye_plugin_deactivation' );

// function to make API call to wordpress bff for deactivate process
function pieeye_plugin_deactivation(){
    $pieeye_consent = get_option('pieeye_optin_consent', false);
    if($pieeye_consent == "true"){
        $url = get_site_url();
        $body = array(
            'site' => $url,
        );
        $header = array(
            'Content-Type' => 'application/json',
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => '45',
            'headers'     => $header,
            'body'        => json_encode($body),
            'cookies'     => array(),
        );
        $response = wp_remote_post(PIEEYE_CONF_API . '/deactivate', $args);
        set_transient('pieeye_banner_script_inserted_' . $url,  false, 2147483647);
        $body = wp_remote_retrieve_body($response);
    }
}

// hook to call wordpress bff on plugin uninstall
register_uninstall_hook(__FILE__, 'pieeye_plugin_uninstall');

// function to make API call to wordpress bff for uninstall process
function pieeye_plugin_uninstall(){
    delete_option('pieeye_optin_consent');
    $pieeye_consent = get_option('pieeye_optin_consent', false);
    if($pieeye_consent == "true"){
        $url = get_site_url();
        $body = array(
            'site' => $url,
        );
        $header = array(
            'Content-Type' => 'application/json',
        );
        $args = array(
            'method'      => 'POST',
            'timeout'     => '45',
            'headers'     => $header,
            'body'        => json_encode($body),
            'cookies'     => array(),
        );
        $response = wp_remote_post(PIEEYE_CONF_API . '/uninstall', $args);
        set_transient('pieeye_banner_script_inserted_' . $url,  false, 2147483647);
        $body = wp_remote_retrieve_body($response);
    }
}

?>