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
    nav.top-bar .menu > li > a {color:<?php echo bb_get_theme_mod('bb_colour1'); ?>;}
    nav.top-bar .menu > li:not(.active) > a {background-color: <?php echo bb_get_theme_mod('bb_colour2'); ?>;}
    nav.top-bar .menu > li.active > a {background-color: rgb(<?php echo bb_colour_darker(bb_get_theme_mod('bb_colour2')); ?>);}
    nav.top-bar .menu > li > a:hover {background-color: rgb(<?php echo bb_colour_lighter(bb_get_theme_mod('bb_colour2')); ?>);opacity:1;}
    nav.top-bar {padding: 0 0 0 0.9375rem;}
    nav.top-bar .fa.fa-bars {display: inline-block; font-size: 2rem; padding: 1rem;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
    nav.top-bar {padding: 0 0.9375rem;}
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
<div class="cell">
<nav class="top-bar hide-for-medium">
<?php
    $small_logo = bb_get_theme_mod(ns_.'logo_small');
?>
    <a href="#" class="float-right" type="button" data-open="offCanvas"><i class="fa fa-bars bg1 text3 hbg3 htext1" aria-hidden="true"></i></a>
    <div class="title-bar-title"><a href="<?php echo site_url(); ?>"><img class="logo" id="small-logo" src="<?php echo $small_logo; ?>" alt=""></a></div>
</nav>
<nav class="top-bar show-for-medium">
    <section class="top-bar-left">
<?php
    $logo = bb_get_theme_mod(ns_.'logo_large');
?>
        <a href="/"><img id="logo" src="<?php echo $logo; ?>" alt=""></a>
    </section>
    <section class="top-bar-right">
        <ul class="menu">
<?php bb_menu('top'); ?>
        </ul>
    </section>
</nav>
</div>
<?php
    // section content - end
    echo '<!-- END:'.$file.' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);
