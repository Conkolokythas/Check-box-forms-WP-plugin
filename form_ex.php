<?php
/*
Plugin Name: ESPA Form
Description: Αμεσος Έλεγχος Eπιλεξιμότητας προγραμμάτων.
Version: 1.0
Author: Kolokythas Konstantinos
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/admin_page.php';
require_once plugin_dir_path(__FILE__) . 'includes/handle_forms.php';
require_once plugin_dir_path(__FILE__) . 'includes/db.php';
include plugin_dir_path(__FILE__) . 'includes/shortcode.php';

add_action('admin_enqueue_scripts', 'load_custom_wp_admin_scripts');

function load_custom_wp_admin_scripts(){
    wp_register_style( 'custom_wp_admin_css', '/wp-content/plugins/form_plugin/assets/css/styles.css');
    wp_enqueue_style( 'custom_wp_admin_css' );
}

add_action('wp_enqueue_scripts', 'load_font_end_styles');

function load_font_end_styles(){
    wp_register_style( 'front-end-form_style', '/wp-content/plugins/form_plugin/assets/css/formstyle.css');
    wp_enqueue_style( 'front-end-form_style' );
}

add_action('admin_print_scripts', 'admin_enqueue_scripts' );

function admin_enqueue_scripts(){
    wp_enqueue_script( 'index-js', plugin_dir_url(__FILE__) . 'assets/js/index.js', array(), '1.0', array('in_footer' => true ));
}

add_action('wp_enqueue_scripts', 'footer_enqueue_scripts' );

function footer_enqueue_scripts(){
    wp_enqueue_script( 'form-js', plugin_dir_url(__FILE__) . 'assets/js/formjs.js', array(), '1.0', array('in_footer' => true ));
}


register_activation_hook(__FILE__, 'create_table');

add_action('admin_menu', 'mcp_admin_menu'); 

function mcp_admin_menu() {
    add_menu_page(
        'Έλεγχος Eπιλεξιμότητας',
        'Έλεγχος Eπιλεξιμότητας',
        'manage_options',
        'my-data',
        'admin_page',
        'dashicons-editor-ul'
    );
}


register_uninstall_hook(__FILE__, 'delete_table');
