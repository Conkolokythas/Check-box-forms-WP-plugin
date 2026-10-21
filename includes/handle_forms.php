<?php 

add_action('admin_post_delete_form', 'delete_form');

function delete_form() {

    if (!current_user_can('manage_options')) {
        wp_die('Δεν έχετε δικαίωμα να εκτελέσετε αυτή την ενέργεια.');
    }

    if (!isset($_GET['id'])) {
        wp_die('Δεν δόθηκε ID.');
    }


    global $wpdb;

    $table_name = $wpdb->prefix . 'forms_espa';

    $id = absint($_GET['id']);

    $wpdb->delete(
        $table_name,
        array(
            'id' => $id
        ),
        array(
            '%d'
        )
    );


    wp_redirect(admin_url('admin.php?page=my-data'));
    exit;

}

add_action('admin_post_update_form', 'update_form');

function update_form() {

    if (is_user_logged_in() && isset($_POST['submit_data'])) {
    $submitted_value = $_REQUEST['_wpnonce'];

        if (!isset($_GET['id'])) {
            wp_die('Δεν δόθηκε ID.');
        }

        if ( ! wp_verify_nonce( $submitted_value, 'update_form' ) ) {
            exit;
            
        } else {

                $id = absint($_GET['id']);
                global $wpdb;
                $table_name = $wpdb->prefix . 'forms_espa';

                $title = sanitize_text_field($_POST['title']);
                $shortcode  = sanitize_text_field($_POST['shortcode']);
                $checkboxes = sanitize_text_field($_POST['q_all']);

                $shortcode_clean = stripslashes($shortcode);

                $wpdb->update(
                    $table_name,
                    [
                        'p_title'  => $title,
                        'p_text' => $checkboxes,
                        'form_shortcode' => $shortcode_clean,
                        'created_at' => current_time('mysql')
                    ],
                    [
                        'id' => $id
                    ]
                );

                wp_redirect(admin_url('admin.php?page=my-data'));
                exit;
            }
    }
}