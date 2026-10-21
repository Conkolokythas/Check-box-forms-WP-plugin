<?php

require_once plugin_dir_path(__FILE__) . 'edit_form.php';

function admin_page() {

   if (!current_user_can('manage_options')) {
        wp_die('Δεν έχετε δικαίωμα να εκτελέσετε αυτή την ενέργεια.');
    }

    if (isset($_GET['id']) && isset($_GET['action'])) {
        $id = absint($_GET['id']);

        edit_form_content($id);
    } 
    
    else 
    
    {
        
        if (is_user_logged_in() && isset($_POST['submit_data'])) {

        $submitted_value = $_REQUEST['_wpnonce'];
        if ( ! wp_verify_nonce( $submitted_value, 'submit_new_form' ) ) {
            exit;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'forms_espa';

        $title = sanitize_text_field($_POST['title']);
        $shortcode  = sanitize_text_field($_POST['shortcode']);
        $checkboxes = sanitize_text_field($_POST['q_all']);
       
        $shortcode_clean = stripslashes($shortcode);

        $wpdb->insert(
            $table_name,
            [
                'p_title'  => $title,
                'p_text' => $checkboxes,
                'form_shortcode' => $shortcode_clean,
            ],
            [
                '%s',
                '%s'
            ]
        );

    }
    ?>
    <div class="wrap">
        <h1>Εισαγωγή Φόρμας 'Αμεσης Eπιλεξιμότητας</h1>
        <hr class="wp-header-end">
        <div class="postbox">
            <div class="postbox-header h-padding">
                <h2>Προσθήκη νέας φόρμας</h2>
            </div>
            <div class="inside">
                <form id="cbForm" method="post">

                        <div>
                            <div>
                                <h4>Τίτλος</h4>
                            </div>
                            <div>
                                <input type="text" name="title" placeholder="Έως 255 χαρακτήρες" required>
                                <span id="excede"></span>
                            </div>
                        </div>

                        <div>
                            <div>
                                <h4>Shortcode φόρμας επικοινωνίας</h4>
                            </div>
                            <div>
                                <input type="text" name="shortcode" placeholder="π.χ.: [contact-form-7 id='123' title='Φόρμα 1']" required>
                            </div>
                        </div>
                        
                        <div>
                            <div>
                            <h4>Ερώτηση</h4>
                            </div>
                            <div>
                                <input type="text" name="cb_q" placeholder="Πάτησε Προσθήκη για εισαγωγή νέας ερώτησης"> <br>
                                 <span id="add" class="pointer button button-primary">Προσθήκη</span>
                                <input type="hidden" name="q_all">
                            </div>
                            <div>
                                <ol id="q"></ol>
                            </div>
                        </div>    
                            
                        <?php wp_nonce_field( 'submit_new_form' ); ?>
                            
                        <?php submit_button('Αποθήκευση', 'primary', 'submit_data'); ?>
                    </form>
            </div>
        </div>

        <?php table_of_contents(); ?>
        
    <?php

    }

}

function table_of_contents() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'forms_espa';
    $results = $wpdb->get_results("SELECT * FROM {$table_name} ORDER BY id DESC");

    ?>

    <div class="postbox plugins">
        <div id="the-tb">
            <div class="activity-block form-block">
                <table>
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Τίτλος</td>
                            <td>Shortcode Φόρμα επικοινωνίας</td>
                            <td>Shortcode ενσωμάτωσης</td>
                            <td>Τελευταία τροποποίηση</td>
                        </tr>
                    </thead>
            <?php

            foreach($results as $row) {
            echo '<tr>';
            echo '<td>'. esc_html($row->id) .'</td>';
            echo '<td>'. esc_html($row->p_title) .' <br>
             <a href=" '. admin_url('admin.php?page=my-data&action=edit&id=' . $row->id).'">Επεξεργασία</a>
              <span><a class="remove pointer" href=" '. admin_url('admin-post.php?action=delete_form&id=' . $row->id).'">Διαγραγή</a></span>
             </td>';
            echo '<td class="prevent-select">'. esc_html($row->form_shortcode) .'</td>';
            echo '<td>[espa_form id="'.$row->id.'"]</td>';
            echo '<td>'. esc_html($row->created_at) .'</td>';
            echo '</tr>';
            }
            ?>
              </table>
            </div>
        </div>
    </div>
</div><!--wrap-->
    <?php
}
