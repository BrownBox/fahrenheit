<?php
/**
 * Based on @version 1.0.3
 *
 * Main content for donate page
 *
 * STEP 2: CODE
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

    .gform_bb.gfield_click_array div.s-html-wrapper.s-passive { background-color: rgba(247, 148, 29, 0.1);  border: 3px solid <?php echo bb_get_theme_mod('bb_colour3');?>!important; border-radius: 2px!important;}
    .gform_bb.gfield_click_array div.s-html-wrapper.s-active { background-color: #f7941d!important; border-radius: 2px!important;}
    .gform_bb.gfield_click_array div.s-html-wrapper div.s-html-value {font-family: 'Arvo'; }
    .gform_bb.gfield_click_array div.s-html-wrapper label {padding: 0!important;}

    body .gform_wrapper .bb_cart_donations .gform_fields .horizontal .gfield_radio > li {display: inline-flex!important; margin-right:1rem;}
    body .gform_wrapper .bb_cart_donations ul.gfield_radio li input[type="radio"]:checked + label {color: #000;font-weight: bold!important;}
    body .gform_wrapper .bb_cart_donations .gform_fields .horizontal .gfield_radio > li > label {vertical-align: top;}

    /* Hiding Navigation for Donation Template */
    #row-footer {display: none;}
    #row-content {margin-bottom: 2rem;}
    #breadcrumbs, #row-hero .menu, #row-hero .announcement-on-small, #row-hero .announcement, #row-hero .off-canvas-menu {visibility: hidden;}
    #row-hero .navigation {background-color: transparent;}

    .featured-image {margin-bottom: 1rem; margin-top: 1rem;border-radius: 2px;}

    .page-template-default.page.page-donate {background-color: #4b4b4b;}

    .gform_bb.gfield_click_array div.s-html-wrapper {min-height: 60px!important;}
    .gform_bb.gfield_click_array div.s-html-wrapper div.s-html-value { font-size: 1.5rem!important;}
    .gform_bb.gfield_click_array div.s-html-wrapper div.s-html-value {margin-top: 10px!important;}
    .gform_bb.gfield_click_array div.s-html-wrapper.s-active label {color: #fff; font-weight: bold;}

    a.pseudo-submit.payment-method.button {background-color: <?php echo bb_get_theme_mod('bb_colour5');?>; font-family: 'Arvo';}
    a.pseudo-submit.payment-method.button:hover {background-color: <?php echo bb_get_theme_mod('bb_colour8');?>;}
    body .gform_wrapper .bb_cart_donations .gform_fields .horizontal .gfield_radio > li > label {background: transparent!important; margin: 0.2rem 0 0 0.5rem;}

    .donations-allocation-section .other-ways i {margin-right: 0.5rem;}
    .donations-allocation-section h4 {font-weight: 700;}
    .donations-allocation-section {background-color: rgba(207, 215, 221, 0.18); padding: 0.25rem 1rem; border-radius: 2px; box-shadow: 0px 1px 2px rgba(0,0,0,0.2);}

    body .gform_wrapper.bb_cart_donations_wrapper li.tabs {background-color: white; margin-left: -0.5rem !important; border:none;}
    body .gform_wrapper.bb_cart_donations_wrapper li.tabs > label {display: none;}
    body .gform_wrapper.bb_cart_donations_wrapper li.tabs ul.gfield_radio {margin-bottom: 2rem!important; min-height: 10px; width: 100%;}
    body .gform_wrapper.bb_cart_donations_wrapper li.tabs ul.gfield_radio li {height: 4rem; margin: 0!important; overflow: visible; float: left; width: 33.3333% !important;}
    body .gform_wrapper.bb_cart_donations_wrapper li.tabs ul.gfield_radio li input[type="radio"] {visibility: hidden; display: none !important;}
    body .gform_wrapper.bb_cart_donations_wrapper li.tabs ul.gfield_radio li label {background-color: #eee; color: black; width: 100%; height: 3.5rem; padding: 0.5rem 1rem!important; margin: 0!important; border-radius: 10px 10px 0 0 !important; max-width:100%;}
    body .gform_wrapper.bb_cart_donations_wrapper li.tabs ul.gfield_radio li input[type="radio"]:checked+label {background-color: <?php echo bb_get_theme_mod('colour4'); ?>; color: white;}
    body .gform_wrapper.bb_cart_donations_wrapper .ginput_bb.ginput_click_array_other { display: block !important;}
    body .gform_wrapper.bb_cart_donations_wrapper .ginput_container label.ginput_bb_click_array_other_label {display: block !important;}
    body .gform_wrapper.bb_cart_donations_wrapper .anonymous .gfield_label {display:none;}
    body .gform_wrapper.bb_cart_donations_wrapper .bb_cart_donations .gform_footer { width: 100%; margin-left: 0;}

    .gform_bb #input_21_4_1 {max-width: 95%;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
    .gform_bb.gfield_click_array div.s-html-wrapper label { font-size: 0.8rem!important; line-height: 1.1;  margin: 0.2rem;}

    .gform_bb.gfield_click_array div.s-html-wrapper {min-height: 85px!important;}
    .gform_bb.gfield_click_array div.s-html-wrapper div.s-html-value { font-size: 1.2rem!important;}

    .gform_bb #input_21_4_1 {max-width: 92%;}

}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    .featured-image {margin-top: 0rem;}

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
@media only screen {}
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
?>
<div class="gift-selection-page-wrapper">
    <div class="small-24 medium-24 large-14 column">
        <h1 class="text4"><?php the_title(); ?></h1>
        <article>
            <?php gravity_form(bb_cart_get_donate_form(), false, false, false, null, false, 12); ?>
            <p><small><strong>Secure 128bit encryption</strong><br>
                Protected by an industry-standard high grade 128bit encryption, using SSL technology.</small></p>
             <img class="secure-seal show-for-small-only float-center" src="<?php echo '../wp-content/uploads/comodo-padlock.png'; ?>" alt="This site is secured with Comodo" width="150" >
            <img class="secure-seal show-for-medium" src="<?php echo '../wp-content/uploads/comodo-padlock.png'; ?>" alt="This site is secured with Comodo" width="150" >
        </article>
    </div>
    <div class="small-24 medium-24 large-10 column">
<?php
            global $post;

            if (has_post_thumbnail( $post->ID ) ){
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
            }
?>
        <div class="row">
            <div class="medium-24 column">
                <img class="featured-image" src="<?php echo $image[0]; ?>" alt="">
            </div>
            <div class="content">
                <?php echo apply_filters('the_content', $post->post_content ) ?>
            </div>
        </div>
    </div>
    <?php ?>
    <div class="small-24 medium-24 large-10 column">
        <div class="donations-allocation-section">
            <div class="row medium-24 column">
                 <p>@todo</p>
            </div>
        	<div class="other-ways">
                <div class="medium-24 donation-options">
                     <p>@todo</p>
                </div>
        	</div>
        </div>
    </div>
    <?php  ?>
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
