<?php
/**
 * Based on @version 1.0.3
 *
 * Section for displaying children as accordion
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
        'children' => bb_get_children($post),
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

    h1 {font-weight: 900; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
    h2 {font-weight: 700; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }

    article {padding-bottom: 1rem;}

    .accordion-title .h2 {font-size: 1rem; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>;}
    .accordion-title::before {font-size: 1.5rem; font-weight: 700;color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; top:35%; }
    .accordion-title, .accordion-content {border-bottom: 1px solid #e6e6e6;}

    

}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ 
    h1 {padding-bottom: 1rem;}
    
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
?>
<div class="small-24 medium-17 large-18 column">
    <h1><?php the_title(); ?></h1>
    <article <?php post_class() ?>>
        <?php echo apply_filters('the_content', $post->post_content); ?>
    </article>
    <div class="accordion" data-accordion data-allow-all-closed="true">
<?php
    $tmp_post = $post;
    foreach ($section_args['children'] as $post) {
        setup_postdata($post);
        $id = $post->ID;
        $slug = get_the_slug($post->ID);
        $title = get_the_title($post);
        $content = apply_filters('the_content', $post->post_content);
?>
        <article id="<?php echo $slug; ?>" class="<?php post_class('child accordion-item', $post->ID); ?>" data-accordion-item>
            <a href="#" class="accordion-title"><span class="h2"><?php echo $title; ?></span></a>
            <div class="accordion-content" data-tab-content>
                <?php echo $content; ?>
            </div>
        </article>
<?php
    }
    $post = $tmp_post;
?>
    </div>
</div>
<aside class="small-24 medium-7 large-6 column">
    <?php get_sidebar(); ?>
</aside>
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
