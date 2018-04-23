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
<div class="small-24 medium-24 large-12 cell">
    <h1 class="text4"><?php the_title(); ?></h1>
    <article>
        <?php gravity_form(bb_cart_get_donate_form(), false, false, false, null, false, 12); ?>
        <p><small><strong>Secure 128bit encryption</strong><br>
            Protected by an industry-standard high grade 128bit encryption, using SSL technology.</small></p>
         <img class="secure-seal show-for-small-only float-center" src="<?php echo '../wp-content/uploads/comodo-padlock.png'; ?>" alt="This site is secured with Comodo" width="150" >
        <img class="secure-seal show-for-medium" src="<?php echo '../wp-content/uploads/comodo-padlock.png'; ?>" alt="This site is secured with Comodo" width="150" >
    </article>
</div>
<div class="small-24 medium-24 large-6 cell">
<?php
    global $post;

    if (has_post_thumbnail( $post->ID ) ){
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    }
?>
    <div class="grid-x grid-margin-x">
        <div class="medium-24 cell">
            <img class="featured-image" src="<?php echo $image[0]; ?>" alt="">
        </div>
        <div class="content">
            <?php echo apply_filters('the_content', $post->post_content ) ?>
        </div>
    </div>
</div>
<div class="small-24 medium-24 large-6 cell">
    <div class="donations-allocation-section grid-x grid-margin-x">
        <div class="medium-12 large-24 cell">
             <p>@todo</p>
        </div>
    	<div class="other-ways medium-12 large-24 cell">
            <div class="donation-options">
                 <p>@todo</p>
            </div>
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
