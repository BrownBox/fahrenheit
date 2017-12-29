<style type="text/css">
	#row-breadcrumbs #breadcrumbs { margin: 0; padding: 0.5rem 0; }
	#row-breadcrumbs {background-color: <?php echo bb_get_theme_mod('bb_colour6');?>; margin-bottom: 1.5rem;}
	#row-breadcrumbs a { color:  <?php echo bb_get_theme_mod('bb_colour1');?>;font-weight: bold;
}
</style>
<?php
if (function_exists('yoast_breadcrumb') && !is_front_page()) {
?>
    <div class="small-24 column show-for-medium">
<?php
    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
?>
    </div>
<?php
}
