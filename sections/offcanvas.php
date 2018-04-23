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
    .off-canvas {background-color: transparent;}
    .off-canvas i {color:<?php echo bb_get_theme_mod('bb_colour6'); ?>;}
    .off-canvas .first a {padding-left:0!important;}
    .off-canvas .menu {list-style-type: none; margin: 1rem 0; padding: 1rem;}
    .off-canvas .menu a {background-color: transparent; color: <?php echo bb_get_theme_mod('bb_colour1'); ?>; }
    .off-canvas .menu a:hover {background-color: transparent; color: <?php echo bb_get_theme_mod('bb_colour9'); ?>; opacity: 1;}
    .off-canvas .menu .active > a {color: <?php echo bb_get_theme_mod('bb_colour3'); ?>;}
    .off-canvas .menu.vertical > li {background-color: transparent; display: block; margin: 0; max-width: 100%; padding-left: 1rem !important; font-weight: 700;text-transform: uppercase;}
    .off-canvas .menu.vertical > li.search-form-container { position:relative;}
    .off-canvas .menu.vertical > li.search-form-container > a > span {position: absolute; top: 12px; left: 25px;}
    .off-canvas .menu.vertical hr {margin-bottom:1rem; margin-top: 0; border-bottom: 1px solid <?php echo bb_get_theme_mod('bb_colour6'); ?>;}

    .off-canvas .menu.vertical > li.donate-button { background-color:<?php echo bb_get_theme_mod('bb_colour3');?>; padding-left: 0 !important; margin-left: 1rem;text-align: center;border-radius: 1.5px;}
    .off-canvas .menu.vertical > li.donate-button:hover { background-color:<?php echo bb_get_theme_mod('bb_colour2');?>;}
    .off-canvas .menu.vertical > li.donate-button > a { color:<?php echo bb_get_theme_mod('bb_colour1');?>;}

    .off-canvas input {-webkit-appearance: none;}
    .off-canvas .search-form input {border: 2px solid <?php echo bb_get_theme_mod('bb_colour6');?>; height: 2.5rem; padding-left:1.5rem;}
    .off-canvas .search-form input[type=submit] {display:none;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */}
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
<div class="off-canvas position-right" id="offCanvas" data-off-canvas>
    <button class="close-button" aria-label="Close menu" type="button" data-close>
        <i class="fas fa-times" aria-hidden="true"></i>
    </button>
    <ul class="vertical menu">
        <li class="first"> <a href="/"> <i class="fas fa-home" aria-hidden="true"></i> HOME </a> </li>
        <li> <hr> </li>
<?php
    bb_menu('main');
    bb_search_menu();
    bb_menu('donate');
?>
    </ul>
</div>
<?php
    // section content - end
    echo '<!-- END:'.$file.' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);
