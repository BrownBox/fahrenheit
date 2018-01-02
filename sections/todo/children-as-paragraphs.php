<?php
/**
 * Based on @version 1.0.3
*
* Section for children as paragraphs
*
* STEP 2: CODE
* @todo code the output markup. focus on grids and layouts for Small, Medium and Large Devices.
* @todo code the local css. Mobile 1st, then medium and large.
*
* STEP 3: SIGN_OFF
* @todo review code quality (& rework as required)
* @todo review and promote css (as required)
* @todo reset transients and retest
* @todo set transients for production.
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
@media only screen {
/*     .sticky.is-stuck.is-at-top {border-bottom: 2px solid #eee; margin-top: 0!important;} */
    h1 {font-weight: 900; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
    h2 {font-weight: 700; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
    hr.pre-paragraph {border-bottom: 1px solid #f2f2f2;margin: 0.25rem;}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */

}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    h1 {padding-bottom: 1rem;}
    article {padding-bottom: 1rem; max-width: 45rem;}
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
$transient = ns_.$section_args['namespace'].'css'.$transient_suffix;
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
$transient = ns_.$section_args['namespace'].'markup'.$transient_suffix;
if (false === $section_args['transients']) {
    delete_transient($transient);
}
if (false === ($ob = get_transient($transient))) {
    ob_start();

    // section content - start
    echo '<!-- START: '.$section_args['filename'].' -->'."\n";

    // section content
?>
<aside class="small-24 medium-8 large-5 column side-wrapper">
    <?php get_sidebar('children-as-paragraphs'); ?>
</aside>
<div class="small-24 medium-16 large-19 column">
<article <?php post_class() ?>>
	<h1><?php echo apply_filters('the_title', $post->post_title); ?></h1>
    <?php echo apply_filters('the_content', $post->post_content); ?>
</article>
<?php
    foreach ($section_args['children'] as $child) {
        echo '<hr class="pre-paragraph">';
        echo get_card(array( 'card' => 'paragraph', 'ID' => $child->ID ));

    }
?>
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
