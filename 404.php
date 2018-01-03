<?php
$blocked = array();
if (defined('BB_SUPER_SEARCH') && BB_SUPER_SEARCH) {


    foreach($blocked as $block) if(strstr($_SERVER['HTTP_REFERER'], $block)) die();

    // Build the redirect URL
    $string = strtolower(trim(str_replace(array('-', '/'), ' ', $_SERVER['REQUEST_URI'])));
    if(true == strstr($string,'?')) $string = substr($string, 0, strpos($string, '?')-1);
    $url = '/?s='.urlencode($string).'&msg=404'."\n";

    $types = array('jpg','css','html','png');
    $trackas = '_';

    foreach($types as $type) {
        if(strstr($_SERVER['REQUEST_URI'], $type)) {
            $bb_tracking = unserialize(get_option('bb_tracking'));
            if(empty($bb_tracking)) $bb_tracking = array();
            if(!in_array('bb_404_'.$type.'_tracking', $bb_tracking)){
                array_push($bb_tracking, 'bb_404_'.$type.'_tracking');
                $bb_tracking = array_unique($bb_tracking);
                update_option('bb_tracking', serialize($bb_tracking));
            }
            $trackas = '_'.$type.'_';
        }
    }

    $bb_tracking = unserialize(get_option('bb_tracking'));
    if(empty($bb_tracking)) $bb_tracking = array();
    array_push($bb_tracking, 'bb_404_tracking');
    $bb_tracking = array_unique($bb_tracking);
    update_option('bb_tracking', serialize($bb_tracking));

    $bb_404_tracking = unserialize(get_option('bb_404'.$trackas.'tracking'));
    if(empty($bb_404_tracking)) $bb_404_tracking = array();
    $bb_404_tracking[trim($_SERVER['REQUEST_URI'])][] = $_SERVER;
    update_option('bb_404'.$trackas.'tracking', serialize($bb_404_tracking));

    // Redirect to search results
    wp_redirect($url);
    exit;
} else {
    get_header();
    bb_theme::section('name=content&file=404.php');
    get_footer();
}