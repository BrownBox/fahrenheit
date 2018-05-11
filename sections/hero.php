<?php
/**
 * @version F.1.0
 *
 */

// -------------------------------
// 1. setup the post and the data
// -------------------------------
global $post;
extract(bb_theme::setup_data(__FILE__));
$t_period = LONG_TERM;
if (is_archive()) {
    if (is_post_type_archive() || (is_home() && !is_front_page())) {
        $title = $archive_page->post_title;
    } else {
        $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        $title = $term->name;
    }
    $images = bb_get_hero_images($archive_page);
} else {
    $title = get_the_title();
    $images = bb_get_hero_images();
}

// -------------------------------------------
// 2. setup local css transient for this file
// -------------------------------------------
$t_args = array('name' => 'css', 'file' => $file);
$transient = BB_Transients::name($t_args);
if (!BB_Transients::use_transients()) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();
?>
<style>
/* START: <?php echo $file.' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {
    #row-hero {color: <?php echo bb_get_theme_mod('bb_colour1'); ?>; text-shadow: 0.05rem 0.05rem 0.05rem rgba(86, 86, 86, 0.4);}
    #row-hero .hero-content {bottom: 1rem; left: 0; position: absolute; margin: 0 0.9375rem;}
    #row-hero h1 {z-index: 99;position: relative;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
     #row-hero .navigation {position:relative; z-index:99;}
}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $file; ?> */
</style>
<?php
    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);

// -------------------------------------------
// 3. setup local css transient for this post
// -------------------------------------------
$t_args = array('name' => 'css'.$transient_suffix, 'file' => $file);
$transient = BB_Transients::name($t_args);
if (!BB_Transients::use_transients()) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();
    if (!empty($images['large'])) {
        $bgpos_x_large = $meta['hero_bgpos_x'];
        $bgpos_y_large = $meta['hero_bgpos_y'];
        $bgpos_x_medium = !empty($meta['hero_bgpos_x_medium']) ? $meta['hero_bgpos_x_medium'] : $bgpos_x_large;
        $bgpos_y_medium = !empty($meta['hero_bgpos_y_medium']) ? $meta['hero_bgpos_y_medium'] : $bgpos_y_large;
        $bgpos_x_small = !empty($meta['hero_bgpos_x_small']) ? $meta['hero_bgpos_x_small'] : $bgpos_x_large;
        $bgpos_y_small = !empty($meta['hero_bgpos_y_small']) ? $meta['hero_bgpos_y_small'] : $bgpos_y_large;
?>
<style>
/* START: <?php echo $file.' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {
    #row-hero {background-color: <?php echo bb_get_theme_mod('colour'.$meta['hero_bgcolour']); ?>;}
    #row-hero:before {background-image: url(<?php echo $images['small']; ?>); background-position: <?php echo $bgpos_x_small.' '.$bgpos_y_small; ?>; opacity: <?php echo $meta['bg_opacity']; ?>;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
    #row-hero:before {background-image: url(<?php echo $images['medium']; ?>); background-position: <?php echo $bgpos_x_medium.' '.$bgpos_y_medium; ?>;}
}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    #row-hero:before {background-image: url(<?php echo $images['large']; ?>); background-position: <?php echo $bgpos_x_large.' '.$bgpos_y_large; ?>;}
}
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $file; ?> */
</style>
<?php
    }
    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);

// ----------------------------
// 4. setup output transient/s
// ----------------------------
$t_args = array('name' => 'markup'.$transient_suffix, 'file' => $file);
$transient = BB_Transients::name($t_args);
if (!BB_Transients::use_transients()) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();

    // section content - start
    echo '<!-- START: '.$file.' -->'."\n";

    // section content
    if (!empty($images['large'])) {
?>
<div class="navigation show-for-medium cell">
       <ul class="menu align-right">
      <?php bb_menu('main'); ?>
       </ul>
   </div>

<div class="hero-content">
<?php
    if (!$meta['hide_title']) {
        echo '<h1>'.$title.'</h1>'."\n";
    }
    if (!empty($meta['hero_tagline'])) {
        echo '<p class="tagline">'.$meta['tagline'].'</p>'."\n";
    }
    if (!empty($meta['hero_destination']) && !empty($meta['hero_action_text'])) {
        echo '<a class="button cta border1 text1 bg0 hbg2 hborder2" href="'.$meta['hero_destination'].'">'.$meta['hero_action_text'].'</a>'."\n";
    }

?>

</div>
<?php
    }

    // section content - end
    echo '<!-- END:'.$file.' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);
