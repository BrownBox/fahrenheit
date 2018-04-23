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
    /* .sticky.is-stuck.is-at-top {border-bottom: 2px solid #eee; margin-top: 0!important;} */
    h1 {font-weight: 900; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
    h2 {font-weight: 700; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
    hr.pre-paragraph {border-bottom: 1px solid #f2f2f2;margin: 0.25rem;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    h1 {padding-bottom: 1rem;}
    article {padding-bottom: 1rem; max-width: 45rem;}
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
<aside class="small-24 medium-8 large-5 cell side-wrapper">
    <?php get_sidebar('children-as-paragraphs'); ?>
</aside>
<div class="small-24 medium-16 large-19 cell">
<article <?php post_class() ?>>
	<h1><?php echo apply_filters('the_title', $post->post_title); ?></h1>
    <?php echo apply_filters('the_content', $post->post_content); ?>
</article>
<?php
    $children = bb_get_children($post);
    foreach ($children as $child) {
        echo '<hr class="pre-paragraph">';
        echo get_card(array('card' => 'paragraph', 'ID' => $child->ID));
    }
?>
</div>
<?php
    // section content - end
    echo '<!-- END:'.$file.' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);
