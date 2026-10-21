<?php

add_shortcode('espa_form', 'create_form');

function create_form($atts){

$atts = shortcode_atts(
        array(
            'id' => ' ',
        ),
        $atts,
        'custom_shortcode'
    );
global $wpdb;
$table_name = $wpdb->prefix . 'forms_espa';
$result = $wpdb->get_results("SELECT p_text, form_shortcode FROM {$table_name} WHERE id = $atts[id]");

ob_start();
?>
<div class="ccs-traceWrap">
  <div class="ccs-traceCard">
      <div class="traceCard-title">

          <h3>Αμεσος Έλεγχος Eπιλεξιμότητας</h3>
          <p>Συμπληρώστε τα παρακάτω πεδία και μάθετε αμέσως εάν μπορείτε να επιδοτηθείτε</p>
      </div>
    <div class="traceCard-checklist">
        
        <span class="checklist-items">
          
        <?php 
        $patern = '/\p{Greek}+[^.!?]*[.]/u';

        preg_match_all($patern, $result[0]->p_text, $matches);

        echo $code = code_constructor($matches);

        ?>
          
        </span>
    </div>
    
    <div id="c-popup">
      <div class="popup-window">
        <h3>Είστε Επιλέξιμοι!</h3>
        <h3>Αίτημα Δωρεάν Προαξιολόγησης Φακέλου</h3>
        
        <?php echo do_shortcode($result[0]->form_shortcode);?>
        
      </div>
    </div>
    
  </div>
</div>


<?php
return ob_get_clean();
}

function code_constructor($elements){

    $code = ' ';

    foreach ($elements[0] as $row) {
    $snipet = '<div class="c-item">
            <span>
                <label>
                    <input class="c-input" type="checkbox">
                    <span class="c-value">'. $row .'</span>
                </label>
                </span>
            </div>';

    $code .= $snipet;
    }

    return $code;
}

