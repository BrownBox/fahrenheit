<?php
/**
 * Based on @version 1.0.3
 *
 * STEP 1: SETUP
 * @todo describe the purpose of this file
 * @todo define $sections_args & @todo set transients to false
 * @todo define local css $transient & @todo set burn time as SHORT_TERM, MEDIUM_TERM or LONG_TERM
 * @todo define the output $transient & @todo set burn time as SHORT_TERM, MEDIUM_TERM or LONG_TERM
 *
 * STEP 2: CODE
 * @todo code the output markup. focus on grids and layouts for Small, Medium and Large Devices.
 * @todo code the local css. Mobile 1st, then medium and large.
 *
 * STEP 3: SIGN_OFF
 * @todo review code quality (& rework as required)
 * @todo review and promote css (as required)
 * @todo reset transients and retest
 * @todo set transients for production
 * @todo leave sign-off name and date
 *
 */

global $post;

if (is_page() || is_single()) {
    $meta = bb_get_post_meta($post->ID);

    $ancestors = get_ancestors($post->ID, get_post_type($post));
    $ancestor_string = '';
    if (!empty($ancestors)) {
        $ancestor_string = '_'.implode('_', $ancestors);
    }
    $transient_suffix = $ancestor_string.'_'.$post->ID;
} else {
    $meta = array();
    if (is_archive()) {
        $transient_suffix = '_'.$post->post_type;
    }
}

$filename = str_replace(get_stylesheet_directory(), "", __FILE__); // Relative path from the theme folder
$transient_suffix .= '_'.md5($filename);

$section_args = array(
        'namespace' => basename(__FILE__, '.php').'_', // Remember to use keywords like 'section' or 'nav' where logical
        'filename'  => $filename,
        'transients' => defined(WP_BB_ENV) && WP_BB_ENV == 'PRODUCTION', // Set this to false to force all transients to refresh
        'transient_suffix' => $transient_suffix,
        'meta' => $meta,
);

// ---------------------------------------
// setup local css transient for this file
// ---------------------------------------
$transient = ns_.$section_args['namespace'].'css_'.$section_args['filename'].'_'.md5($section_args['filename']);
if (false === $section_args['transients']) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();
?>
<style>
/* START: <?php echo $section_args['filename'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {
    #row-footer {padding-top:1rem; border-top: 1px solid #cacaca;}
    #row-footer i {color:<?php echo bb_get_theme_mod('bb_colour6'); ?>; padding-right: 0.5rem;}
    #row-footer .logo {width: 100%;}
    #row-footer .logo-registered {max-width: 80%; padding-bottom: 1rem;}
    #row-footer .about {padding-top: 1rem;font-size: 1rem;font-weight: 400;}

    #row-footer .search_wrapper {padding-bottom: 1rem;}
    #row-footer .search_wrapper .search-form { border: 2px solid <?php echo bb_get_theme_mod('bb_colour6');?>; position:relative;}
    #row-footer .search_wrapper .search-form input { margin-bottom:0; border-radius: 0;}
    #row-footer .search_wrapper .search-form input[type=submit] {position: absolute;top: 0;right: 0;padding: 0.39rem 1rem;border:none; border-radius: 0; background-color: <?php echo bb_get_theme_mod('bb_colour6');?>; color:<?php echo bb_get_theme_mod('bb_colour1');?>;}
    #row-footer .button {position: absolute;margin-top: -2.7rem;background-color: transparent;}
    #row-footer .search_wrapper .search-form input {padding-left: 2rem;}

    #row-footer hr {margin-top:0; border: 2px solid <?php echo bb_get_theme_mod('bb_colour6');?>; }
    #row-footer .h4 {font-size: 1.2rem;margin-bottom: 0.4rem;}

    #row-footer li {text-align: center; list-style: none; font-size: 1.2rem; padding-bottom: 0.4rem;}
    #row-footer li > a {color: <?php echo bb_get_theme_mod('bb_colour8');?>;font-size: 1.2rem;}
    #row-footer ul {margin-left: 0;}

}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
    #row-footer li > a {font-size: 0.9rem;}
    #row-footer .green-line > a { border-bottom: 4px solid <?php echo bb_get_theme_mod('bb_colour6');?>; display:block; font-size: 1.25rem; margin-bottom: 0.4rem;}
    #row-footer .h4 {margin-bottom: 0.5rem;}
    #row-footer li {text-align: left; padding-left: 0; padding-right: 1.5rem;  padding-bottom: 0.2rem;}
    #row-footer .contact {padding-top: 0.2rem;}
    #row-footer .subscribe .gform_body { display: inline-block !important; width: 100% !important; max-width:100% !important;}

}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    #row-footer {padding-top:2rem;}


 }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<?php
    $ob = ob_get_clean();
    if (true === $section_args['transients']) {
        set_transient($transient, $ob, LONG_TERM);
    }
    echo $ob; // Intentionally inside transient check as if transient exists, will be output in header.php
    unset($ob);
}
unset($transient);

// ---------------------------------------
// setup local css transient for this post
// ---------------------------------------
$transient = ns_.$section_args['namespace'].'css'.$section_args['transient_suffix'];
if (false === $section_args['transients']) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();
?>
<style>
/* START: <?php echo $section_args['filename'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {

}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */


}
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<?php
    $ob = ob_get_clean();
    if (true === $section_args['transients']) {
        set_transient($transient, $ob, LONG_TERM);
    }
    echo $ob; // Intentionally inside transient check as if transient exists, will be output in header.php
    unset($ob);
}
unset($transient);

// ------------------------
// setup output transient/s
// ------------------------
$transient = ns_.$section_args['namespace'].'markup'.$section_args['transient_suffix'];
if (false === $section_args['transients']) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();

    // section content - start
    echo '<!-- START: '.$section_args['filename'].' -->'."\n";

    // section content
    $logo_footer = bb_get_theme_mod(ns_.'logo_footer');
    $footer_text = bb_get_theme_mod(ns_.'footer_text');
    $email = bb_get_theme_mod(ns_.'contact_email');
    $phone = bb_get_theme_mod(ns_.'contact_phone');
    $address = bb_get_theme_mod(ns_.'contact_address');


?>
<div class="small-24 medium-7 column hide-for-print" data-swiftype-index="false">
    <img class="logo" src="<?php echo $logo_footer; ?>" alt="">
    <p class="h3 about"><?php echo $footer_text; ?></p>
   <?php
     echo '<div class="search_wrapper">'."\n";
        get_search_form();
     echo '  <a href="#" class="button button-search margin-zero radius-zero" onclick="jQuery(this).parent().find(\'form.search-form\').submit();">'."\n";
     echo '      <span class="show-for-sr">Search</span>'."\n";
     echo '      <span aria-hidden="true"><i class="fa fa-search margin-zero" aria-hidden="true"></i></span>'."\n";
     echo '  </a>'."\n";
     echo '</div>'."\n";
   ?>

</div>
<div class="show-for-medium medium-11 column">
    <ul class="medium-12 column">
        <?php bb_menu(array('menu' => 'footer-left', 'display_children' => true)); ?>
    </ul>
    <ul class="medium-12 column">
        <?php bb_menu(array('menu' => 'footer-right','display_children' => true)); ?>
    </ul>
</div>
<div class="show-for-small-only small-24 column">
    <ul class="small-up-1">
        <?php bb_menu(array('menu' => 'footer-left', 'display_children' => false)); ?>
        <?php bb_menu(array('menu' => 'footer-right', 'display_children' => false)); ?>
    </ul>
</div>
<div class="small-24 medium-6 column">
    <div class="small-12 medium-24 column contact">
        <p class="h4">Contact Us</p>
        <hr class="menu-title">
        <p><?php echo $address; ?></p>
        <p><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $email; ?></p>
        <p><i class="fa fa-phone" aria-hidden="true"></i><?php echo $phone; ?></p>
    </div>
</div>
<?php
    // section content - end
    echo '<!-- END:'.$section_args['filename'].' -->'."\n";

    $ob = ob_get_clean();
    if (true === $section_args['transients']) {
        set_transient($transient, $ob, LONG_TERM);
    }
}
echo $ob;
unset($ob);
unset($transient);

