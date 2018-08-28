<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function tts_quoteRotator_func($atts){
    global $quoteRotator, $wpdb;
    extract( shortcode_atts( array(
         'title' => '',
         'delay' => '',
         'fade' => '',
         'fadeout' => '',
         ), $atts ) );
		
    $delay = get_option('fqr_delay');
    if (!isset($delay) || $delay == "") $delay = 5;
    $fade = get_option('fqr_fade');
    if (!isset($fade) || $fade == "") $fade = 2;
    $fadeout = get_option('fqr_fadeout');
    if (!isset($fadeout) || $fadeout == "") $fadeout = 0;
    $random = get_option('fqr_random');
    if (!isset($random) || $random == "") $random = 0;
    $openquote = get_option('fqr_openquote');
    if (!isset($openquote) || $openquote == "") {
        $openquote = "";
    } else {
       $openquote = "<span id='openquote' class='quotemark'>" . $openquote . '</span>';
    }
    $closequote = get_option('fqr_closequote');
    if (!isset($closequote) || $closequote == "") {
       $closequote = "";
    } else {
       $closequote = "<span id='closequote' class='quotemark'>" . $closequote . '</span>';
    }

    if($random){
        $sql = "SELECT * FROM " . $quoteRotator->tableName . " ORDER BY RAND(".time().")";
    }else{
        $sql = "SELECT * FROM " . $quoteRotator->tableName . " ORDER BY id";
    }
    $results = $wpdb->get_results($sql);
    $quotes_lis = '';
    $q_count = 0;
    foreach($results as $result){
        if($q_count == 0){
            $q_class = 'quote-li active-quote-li';
        }else{
            $q_class = 'quote-li';
        }
        $q_count++;
        $quotes_lis .= '<li class="' . $q_class. '"><span class="tts-quote">' . stripcslashes($result->quote) . '</span>';
        if($result->author != ''){
            $quotes_lis .= ' <span class="tts-quoteauthor">' . $result->author . '</span>';
        }
        $quotes_lis .= '</li>';
    }

    $style = "";
    if (get_option('fqr_height') != "") $style .= "height:".get_option('fqr_height')."px;";
    if (get_option('fqr_width') != "") $style .= "width:".get_option('fqr_width')."px;";
    if ($style != "") $style = " style='".$style."'";
    ob_start();
?> 
<div id="quotearea" <?php echo $style; ?>>
    <div id="quoterotator" >
        <?php if(!$quotes_lis){ ?>
        <span class="tts-no-quotes">No Quotes Found</span>
        <?php }else{ 
            $qw_id = 'qw-' . rand(1111, 9999);
            echo '<ul class="tts-quotes-list" id="'. $qw_id .'">' . $quotes_lis . '</ul>';
        } 
        ?>
    </div>
    <?php 
    if( $q_count > 1){ 
        $interval = absint($delay) + absint($fade) + absint($fadeout);
        if($interval){
            $interval = $interval * 1000;
        }else{
            $interval = 7000;
        }
    ?>
    <script type="text/javascript">
    (function($){
        $(document).ready(function(){
            var current = $("#<?php echo $qw_id; ?>").find(".active-quote-li");
            setInterval(function(){
                var next;
                if(current.is(":last-child")){
                    next = $("#<?php echo $qw_id; ?>").find(".quote-li:first-child");
                }else{
                    next = current.next();
                }
                current.removeClass('active-quote-li');
                next.addClass('active-quote-li');
                current = next;
            }, <?php echo $interval; ?>);
        });
    })(jQuery);
    </script>
    <?php }?>
</div>

<?php
    return ob_get_clean() ;
}

function tts_remove_quote_rotator_defaults(){
    global $quoteRotator;
    remove_action('wp_head', array(&$quoteRotator, 'addHeaderContent'));
    remove_shortcode('quoteRotator');
    add_shortcode('quoteRotator', 'tts_quoteRotator_func');
}

add_action('template_redirect', 'tts_remove_quote_rotator_defaults');


/**
 * Register meta box for qoutes sidebar.
 */
function tts_quotes_mb_register() {
    add_meta_box( 'quotes-sidbar-mb', __( 'Quotes Widget Control', 'twentyten' ), 'tts_quotes_mb_cb', array('page'), 'side', 'high' );
}
function tts_quotes_mb_cb($post){
    $disabled = get_post_meta($post->ID, 'tts_disable_quotes_sb', true);
    wp_nonce_field( 'tts_save_qsba', 'tts_save_qsbn' );
?> 
<div>
    <label><input type="checkbox" name="tts_disable_quotes_sb" value="1" <?php checked($disabled, 'yes', true);?> /><strong>Disable Quotes Widget</strong></label>
</div>
<?php
}

function tts_quotes_mb_save($post_id, $post){
    // Add nonce for security and authentication.
    $nonce_name   = isset( $_POST['tts_save_qsbn'] ) ? $_POST['tts_save_qsbn'] : '';
    $nonce_action = 'tts_save_qsba';

    // Check if nonce is set.
    if ( !$nonce_name) {
        return;
    }

    // Check if nonce is valid.
    if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
        return;
    }

    if(!empty($_POST['tts_disable_quotes_sb'])){
        
        update_post_meta($post_id, 'tts_disable_quotes_sb', 'yes');
    }else{
        delete_post_meta($post_id, 'tts_disable_quotes_sb');
    }
}

add_action( 'add_meta_boxes', 'tts_quotes_mb_register' );
add_action( 'save_post',    'tts_quotes_mb_save', 10, 2 );
