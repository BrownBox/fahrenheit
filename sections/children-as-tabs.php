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
    #row-children-as-tabs .tabs-content.vertical { border: none;}
    h1 {font-weight: 900; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; padding-left: 1rem;}
    h2 {font-weight: 700; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>;}
    aside .menu > li > a {color: <?php echo bb_get_theme_mod('bb_colour8');?>; text-transform: uppercase; font-weight: 700;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    h1 {padding-bottom: 1rem;}
    #row-children-as-tabs .tabs-content {max-width: 45rem;}
}
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
?>
<style>
/* START: <?php echo $file.' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
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
    ?>
    <div class="children-as-tabs small-24 cell grid-x grid-margin-x" data-equalizer="tabs" data-equalize-on="medium">
        <aside class="medium-8 large-5 cell" data-equalizer-watch="tabs">
            <?php get_sidebar('children-as-tabs'); ?>
        </aside>
        <div class="small-24 medium-16 large-19 float-left cell">
            <h1><?php echo $post->post_title; ?></h1>
            <div class="tabs-content vertical" data-tabs-content="about-us-tabs">
<?php
    $is_active = false;
    if (!empty($post->post_content)) {
        echo '<div class="tabs-panel is-active" id="'. $post->post_name .'" data-equalizer-watch="tabs">'."\n";
        echo apply_filters('the_content', $post->post_content);
        echo '</div>'."\n";
        $is_active = true;
    }

    $children = bb_get_children($post);
    foreach ($children as $child) {
        if ($is_active == false) {
            $class = 'is-active';
            $is_active = true;
        } else {
            $class = '';
        }
        $slug = get_the_slug($child->ID);
        echo '<div class="tabs-panel '.$class.'" id="'. $slug .'" data-equalizer-watch="tabs">'."\n";
        echo '<h2>'.$child->post_title.'</h2>'."\n";
        echo apply_filters('the_content', $child->post_content);
        echo '</div>'."\n";
        if (bb_has_children($child->ID)) { // If child page has children of its own, add them too
            foreach (bb_get_children($child) as $grandchild) {
                echo '<div class="tabs-panel" id="'.get_the_slug($grandchild->ID).'" data-equalizer-watch>'."\n";
                echo '<h2>'.$grandchild->post_title.'</h2>'."\n";
                echo apply_filters('the_content', $grandchild->post_content);
                echo '</div>'."\n";
            }
        }
        unset($class);
    }
?>
            </div>
        </div>
    </div>
<?php
    // section content - end
    echo '<!-- END:'.$file.' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);
