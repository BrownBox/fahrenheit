<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<?php
$favicon = bb_get_theme_mod(ns_.'favicon');
if ($favicon) {
    echo '        <link rel="icon" href="'.$favicon.'" type="image/png">'."\n";
}
wp_head();
?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

//     ga('create', 'UA-67704837-1', 'auto'); @todo
    ga('send', 'pageview');
</script>
<style>
/* START: <?php echo $t_args['file'].' - '.date("Y-m-d H:i:s"); ?> */
@media only screen {
    header {background-image: url(<?php echo bb_get_theme_mod(ns_.'pattern1'); ?>);}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */ }
@media only screen and (min-width: <?php echo ROW_MAX_WIDTH; ?> ) {}
@media only screen and (min-width: <?php echo SITE_MAX_WIDTH; ?> ) {}
/* END: <?php echo $section_args['filename']; ?> */
</style>
    </head>
    <body <?php body_class(bb_theme::classes()); ?>>
    <!-- start everything -->
    <div class="everything">
<?php locate_template(array('sections/offcanvas.php'), true); ?>
        <div class="off-canvas-content" data-off-canvas-content>
            <header class="hide-for-print clearfix">
<?php
bb_theme::section('name=top&file=top.php');
bb_theme::section('name=hero&file=hero.php&class=full&inner_class=row relative hero-height ');
bb_theme::section('name=breadcrumbs&file=breadcrumbs.php');
?>
            </header>
            <section class="main-section">
<?php
bb_show_panels('top');
