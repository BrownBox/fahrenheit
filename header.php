<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta class="swiftype" name="title" data-type="string" content="<?php the_title(); ?>">
        <meta class='swiftype' name='type' data-type='enum' content='<?php echo ucfirst(get_post_type()); ?>'>
<?php
if (has_post_thumbnail()) {
    $thumbnail = bb_get_featured_image_url('medium');
?>
        <meta class='swiftype' name='image' data-type='enum' content='<?php echo $thumbnail[0]; ?>'>
<?php
}
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

  ga('create', 'UA-67704837-1', 'auto');
  ga('send', 'pageview');

</script>

        <style>
<?php echo BB_Transients::clean(array('string' => 'css', 'clean' => array('<style>', '</style>', '  '))); ?>
        </style>
    </head>
    <body <?php body_class(bb_theme::classes()); ?>>
    <!-- start everything -->
    <div class="everything">
		<div class="off-canvas-wrapper">
			<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper><!-- off-canvas left menu -->
<?php locate_template(array('sections/offcanvas.php'), true); ?>
				<div class="off-canvas-content" data-off-canvas-content>
                    <header data-swiftype-index='false' class="hide-for-print clearfix">
<?php
// bb_theme::section('name=top&file=top.php&inner_class=row&class=bg1 gradient'); // includes logo and top menu by default
// bb_theme::section('name=menu&file=menu.php&inner_class=row&class=bg5 show-for-medium');
bb_theme::section('name=hero&file=new-hero.php&inner_class=row relative hero-height');
bb_theme::section('name=breadcrumbs&file=breadcrumbs.php&inner_class=row');
?>
                    </header>
                    <section class="main-section">
<?php
bb_theme::section('name=panels-top&file=panels-top.php&inner_class=row-full');
