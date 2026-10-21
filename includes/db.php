<?php

function create_table() {

global $wpdb;
$table_name = $wpdb->prefix . 'forms_espa';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        p_title VARCHAR(255) NOT NULL,
        p_text LONGTEXT,
        form_shortcode VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

echo $table_name;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);
}

function delete_table() {
    global $wpdb;
    $db = $wpdb->dbname;
    $table_name = $wpdb->prefix . 'forms_espa';

    $sql = "DROP TABLE IF EXISTS  $table_name;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $wpdb->query($sql);
}
