<?php
/**
 * Based on @version 1.0.3
*
* Checkout template
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

if (is_archive()) {
    $archive_page = get_page_by_path(get_post_type($post));
    $meta = bb_get_post_meta($archive_page->ID);
    $transient_suffix = '_'.get_post_type($post);
} elseif (is_home() && !is_front_page()) {
    $blog_page = get_option('page_for_posts', true);
    $meta = bb_get_post_meta($blog_page);
    $transient_suffix = '_'.get_post_type($post);
} else {
    $ancestors = get_ancestors($post->ID, get_post_type($post));
    $ancestor_string = '';
    if (!empty($ancestors)) {
        $ancestor_string = '_'.implode('_', $ancestors);
    }
    $transient_suffix = $ancestor_string.'_'.$post->ID;
    $meta = bb_get_post_meta($post->ID);
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
    body .gform_wrapper.bb_cart_checkout_wrapper .gform_fields .payment_options .gfield_radio li label { margin: 0.2rem 0 0 0.3rem; max-width:100%;}
    body .gform_wrapper.bb_cart_checkout_wrapper .gform_fields .payment_options .gfield_radio li input { margin-bottom:0.4rem;}
    body .gform_wrapper.bb_cart_checkout_wrapper .gform_fields .payment_options .gfield_radio li { margin-right:1rem;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
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
    #breadcrumbs {visibility: hidden;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
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
// No transients here as it's always based on user session
// ---------------------------------------

// section content - start
echo '<!-- START: '.$section_args['filename'].' -->'."\n";

// section content
echo '<div class="small-24 medium-9 medium-push-15 large-7 large-push-17 column">'."\n";
echo do_shortcode('[bb_cart_table]');
echo '</div>'."\n";
echo '<div class="small-24 medium-15 medium-pull-9 large-17 large-pull-7 column">'."\n";
echo gravity_form(bb_cart_get_checkout_form(), false, false, false, null, false, 12);
echo '</div>'."\n";

// section content - end
echo '<!-- END:'.$section_args['filename'].' -->'."\n";
