<?php
/**
 * Simplifying working with multiple cards
 * @version 1.0
 * @author Chris Chatterton <chris@brownbox.net.au> - Base functionality
 */

function get_card($args){
    is_array($args) ? extract($args) : parse_str($args);

    // set defaults
    if(is_int($args)) $ID = $args;
    if(!is_array($args) && !strstr($args, '&')) $card = $args;
    if(!isset($card) && !isset($ID)) return;
    if(!isset($ID)) $ID = $card;
    if(!isset($card)) $card = 'search';
    if(!isset($max)) $max = 70;
    if (!empty($type)) {
        $card .= '.'.$type;
    }
    
    $transient_args = array(
            'namespace' => 'card_', // Remember to use keywords like 'section' or 'nav' where logical
            'transients' => false, // Set this to false to force all transients to refresh
    );

    $transient = ns_.$transient_args['namespace'].$ID.'_'.$card;
    if (false === $transient_args['transients']) delete_transient($transient);
    if (false === ($ob = get_transient($transient))) {
        ob_start();

        echo '<!-- START Card '.$ID.' -->'."\n";

        if(file_exists(get_stylesheet_directory().'/cards/'.$card.'.php')) {
            include(get_stylesheet_directory().'/cards/'.$card.'.php');
        } else {
            echo 'No card "/cards/'.$card.'.php" template :(';
        }

        echo '<!-- END Card '.$ID.' -->'."\n";

        $ob = ob_get_clean();
        if (true === $section_args['transients']) set_transient($transient, $ob, LONG_TERM);
    }
    unset($transient);
    
    return $ob;

}