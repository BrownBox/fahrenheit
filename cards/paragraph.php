<style>
/* START: <?php echo $section_args['filename'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
    .content {max-width:45rem;}
}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<?php
$child = get_post($ID);
if (!empty($child->post_excerpt)) {
    $content = apply_filters('the_content', $child->post_excerpt);
} else {
    $content = apply_filters('the_content', $child->post_content);
}
$read_more_label = bb_get_theme_mod(ns_ . 'read_more_label', __( 'Read More'), ns_);
$read_more_link = !empty($child->post_excerpt) || bb_has_children($child->ID) ? '<p class="button float-left bg5 hbg8"><a class="text1 htext1 gf3" href="' . get_the_slug($child->ID) . '">' . $read_more_label . '</a></p>' : '';
if (has_post_thumbnail( $child->ID ) ){
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $child->ID ), 'large' );
}
?>
	<div id="<?php echo $child->post_name; ?>" class="paragraph-card grid-x grid-margin-x">
		<span class="small-24 cell h2 show-for-medium"><?php echo $child->post_title; ?></span>
    	<div class="small-24 cell content">
        	<span class="h2 hide-for-medium"><?php echo $child->post_title; ?></span>
        	<?php echo $content; ?>
        	<?php echo $read_more_link; ?>
    	</div>
    </div>