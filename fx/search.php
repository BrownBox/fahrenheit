<?php

// version 0.1

register_nav_menus(array('search'=>'Search'));

function bb_search_menu($args){
    is_array($args) ? extract($args) : parse_str($args);

    // $args = array( 'output' => 'return');
    // 'output=retrun';

    if (!isset($output)) $output = 'echo'; // function accepts 'echo' or 'return'
    if (!isset($menu_name)) $menu_name = 'search';

    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        if(count($menu_items) > 0 ){
            ob_start();

            echo '<style>#row-hero .off-canvas-search {display:none;}</style>'."\n";
            bb_menu($menu_name);

            foreach((array)$menu_items as $key => $menu_item){
                foreach ($menu_item->classes as $class){
                    if ($class == 'show-search') {
                        echo '<li class="search-form-container off-canvas-search">'."\n";
                        get_search_form();
                        echo '  <a href="#" class="button button-search margin-zero radius-zero" onclick="jQuery(this).parent().find(\'form.search-form\').submit();">'."\n";
                        echo '      <span class="show-for-sr">Search</span>'."\n";
                        echo '      <span aria-hidden="true"><i class="fa fa-search margin-zero" aria-hidden="true"></i></span>'."\n";
                        echo '  </a>'."\n";
                        echo '</li>'."\n";
                    }
                }
            }

            $ob = ob_get_clean();

            if($output == 'echo') {
                echo $ob;
            } elseif($output === 'return') {
                return $ob;
            }
        }
    }
    return;

}


?>