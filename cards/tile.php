<style>
/* START: <?php echo $section_args['filename'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {
    .tile-menu-header {text-align: left; padding: 0.75rem;background-color: <?php echo bb_get_theme_mod('bb_colour4');?>;}
    .child-tiles span {display: table-cell;vertical-align: bottom;}
    .child-tiles h2 {margin-bottom: 0;font-size: 1rem;}
    .child-tiles .image:hover::before { background-color: rgba(221, 221, 221, 0.1);}
    .child-tiles a:link:hover:not(.cta):not(.button) {opacity: 1;}
    .child-tiles .column {margin-bottom: 2rem;}
    .child-tiles .child .image:hover {opacity: 1;}

}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */
    .tile-menu-header {padding: 0.5rem;}
}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */
    .tile-menu-header {padding: 0.5rem;}

}
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
<article id="<?php echo $slug; ?>" <?php post_class('child column', $post->ID); ?>>
    <div class="image" style="background-image:url('<?php echo $image; ?>')">
        <a class="link" href="<?php echo get_permalink($ID); ?>"><span><h2 class="tile-menu-header text1 uppercase"><?php echo $title; ?></h2></span></a>
    </div>
</article>