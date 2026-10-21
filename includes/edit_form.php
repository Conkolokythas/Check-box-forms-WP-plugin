<?php

function edit_form_content($id){

global $wpdb;
$table_name = $wpdb->prefix . 'forms_espa';
$results = $wpdb->get_results("SELECT id, p_title, p_text, form_shortcode FROM {$table_name} WHERE id = $id ");
?>

<div class="wrap">

    <h1>Επεξεργασία στοιχείων</h1>

    <?php 
    echo '<form id="cbForm" method="post" action=" '. admin_url('admin-post.php?action=update_form&id=' . $results[0]->id) .' ">';
    ?>


        <div>
            <div>
                <h4>Τίτλος</h4>
                </div>
                    <div>
                    <?php 
                        echo '<input type="text" name="title" value="'. esc_html($results[0]->p_title) .'" placeholder="Έως 255 χαρακτήρες">';
                    ?>
                    </div>
                </div>

                <div>
                    <div>
                        <h4>Shortcode φόρμας επικοινωνίας</h4>
                    </div>
                    <div>
                    <?php 
                    echo '<input type="text" name="shortcode" value="'. esc_html($results[0]->form_shortcode) .'">';
                    ?>
                                
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
                            <ol id="q">
                            <?php 
                            $patern = '/\p{Greek}+[^.!?]*[.]/u';

                            preg_match_all($patern, $results[0]->p_text, $matches);
                            echo "hi";
                            echo print_q_fields($matches);
                            ?>
                            </ol>
                    </div>
                </div>    
                            
            <?php wp_nonce_field( 'update_form' ); ?>   
            <input type="submit" value="Αποθήκευση" name="submit_data" class="pointer button button-primary">

    </form>
</div>    
<?php

}

function print_q_fields($elements){

    $code = ' ';

    foreach ($elements[0] as $row) {
    $snipet = '<li>
        <input type="hidden" name="cb_q_hidden" value=" '. $row .' ">
        </li>';

    $code .= $snipet;
    }

    return $code;
} 


?>