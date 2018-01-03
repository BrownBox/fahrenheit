<?php
/**
 * @version F.1.0
 *
 */

// -------------------------------
// 1. setup the post and the data
// -------------------------------
global $post;
extract(setup_data($post->ID));
$t_period = LONG_TERM;

// ----------------------------------------------
// 2. setup local css transient for this post ID
// ----------------------------------------------
$t_args = array('name' => 'css_'.$post->ID, 'file' => __FILE__);
if ($_GET['transient'] == 'false') delete_transient(BB_Transients::name($t_args));
if (false === ($ob = get_transient(BB_Transients::name($t_args)))) {
    ob_start();
?>
<style>
/* START: <?php echo $t_args['file'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<?php
    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob);
unset($t_args);

// -------------------------------------------
// 3. setup local css transient for this file
// -------------------------------------------
$t_args = array('name' => 'css', 'file' => __FILE__);
if ($_GET['transient'] == 'false') delete_transient(BB_Transients::name($t_args));
if (false === ($ob = get_transient(BB_Transients::name($t_args)))) {
    ob_start();
?>
<style>
/* START: <?php echo $t_args['file'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<?php
    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob);
unset($t_args);

// ----------------------------
// 4. setup output transient/s
// ----------------------------
$t_args = array('name' => 'markup', 'file' => __FILE__);
if ($_GET['transient'] == 'false') delete_transient(BB_Transients::name($t_args));
if (false === ($ob = get_transient(BB_Transients::name($t_args)))) {
    ob_start();

    // section content - start
    echo '<!-- START: '.$t_args['file'].' -->'."\n";

    // section content
    echo __FILE__;

    // section content - end
    echo '<!-- END:'.$t_args['file'].' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob);
unset($t_args);
