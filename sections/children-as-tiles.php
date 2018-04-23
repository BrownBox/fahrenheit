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
    h1 {font-weight: 900; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
    h2 {font-weight: 700; color:<?php echo bb_get_theme_mod('bb_colour5'); ?>; }
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */ }
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    h1 {padding-bottom: 1rem;}
    article {padding-bottom: 1rem;}
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
<div class="small-24 medium-15 large-17 cell">
    <h1><?php the_title(); ?></h1>
    <article <?php post_class() ?>>
        <?php echo apply_filters('the_content', $post->post_content); ?>
    </article>
    <div class="grid-x grid-margin-x small-up-1 medium-up-2 large-up-3 child-tiles text-center">
<?php
$children = bb_get_children($post);
$tmp_post = $post;
foreach ($children as $post) {
    setup_postdata($post);
    $id = $post->ID;
    $slug = get_the_slug($post->ID);
    $title = get_the_title($post);
    if (!empty($post->post_excerpt)) {
        $content = apply_filters('the_content', get_the_excerpt());
    } else {
        $content = apply_filters('the_content', $post->post_content);
    }

    $image = get_value_from_hierarchy('featured_image', $post->ID);
    if (!empty($image)) {
        $image_style = 'background-image: url('.$image.'); background-position: center center;';

        $args = array(
                'ID'    => $post->ID,
                'card'  => 'tile',
                'image' => $image,
                'title' => $title,
        );
        echo get_card($args);
    }
}
$post = $tmp_post;
?>
    </div>
</div>
<aside class="small-24 medium-9 large-7 column">
    <?php get_sidebar(); ?>
</aside>
<?php
    // section content - end
    echo '<!-- END:'.$file.' -->'."\n";

    $ob = ob_get_clean();
    set_transient($transient, $ob, $t_period);
}
echo $ob;
unset($ob, $t_args, $transient);
