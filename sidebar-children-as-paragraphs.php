<style>
/* START: <?php echo $section_args['filename'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {

    aside .row.sticky-container {margin-bottom: 1rem;}
    aside .menu > li > a { color: <?php echo bb_get_theme_mod('bb_colour4');?>;text-transform: uppercase;font-weight: 700;}
    aside .sticky {background-color: <?php echo bb_get_theme_mod('bb_colour4'); ?>; }
    aside .menu > li > a {color: <?php echo bb_get_theme_mod('bb_colour1'); ?>;}
    aside .is-accordion-submenu-parent > a::after {border-color: <?php echo bb_get_theme_mod('bb_colour1'); ?> transparent transparent;}
    aside .menu.nested {margin-left: 0;}
    aside hr {margin: 0;}
    /*aside ul li:last-of-type hr {display: none;}*/

    aside .sticky.is-stuck.is-at-top {margin-top: 0!important;}
    aside {margin-top: -1.5rem;}

}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
     aside .menu > li > a {color: <?php echo bb_get_theme_mod('bb_colour8'); ?>;}
     aside {margin-top: 0;}
}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>

<?php
/**
 * Children as paragraph sidebar
 */
global $post;

if (!isset($children)) { // In theory section that includes the sidebar should be getting list of children before including it, but just in case...
    $children = bb_get_children($post);
}

$has_children = true;
$menu_items = $children;
if (empty($menu_items) && $post->post_parent > 0) { // No children, get siblings
    $has_children = false;
    $menu_items = bb_get_children($post->post_parent);
}

$menu = '';
foreach ($menu_items as $item) {
    $menu .= '        <li>'."\n";
    if (bb_has_children($item->ID) || !empty($item->post_excerpt)) { // If page has children or excerpt, link to the actual page
        $menu .= '            <a href="'.get_permalink($item->ID).'">'.$item->post_title.'</a><hr>'."\n";
    } elseif (!$has_children) { // If we're showing siblings (and not linking to the full page), link to the anchor on the parent page
        $menu .= '            <a href="'.get_the_permalink($post->post_parent).'#'.get_the_slug($item->ID).'">'.$item->post_title.'</a><hr>'."\n";
    } else { // Otherwise just link to the anchor on the current page
        $menu .= '            <a href="#'.get_the_slug($item->ID).'">'.$item->post_title.'</a><hr>'."\n";
    }
    $menu .= '        </li>'."\n";
}

if (!empty($menu)) {
?>
<div class="hide-for-medium row" data-sticky-container>
    <div class="sticky small-24 column" data-sticky data-sticky-on="small" data-anchor="row-content">
        <ul class="menu vertical" data-accordion-menu>
            <li>
                <a href="#">Quicklinks</a>
                <ul class="menu vertical nested">
<?php echo $menu; ?>
                </ul>
            </li>
        </ul>
    </div>
</div>
<ul class="show-for-medium menu vertical">
<?php echo $menu; ?>
</ul>
<?php
}
