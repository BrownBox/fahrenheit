<style>
@media only screen {
    .tile.article.row {margin-left: auto; margin-right: auto;}
    .article .title {font-weight: 900; font-size: 1rem; margin-bottom: 0.4rem;}
    .article .image {height: 120px; background-size: cover; background-position: center center;}
    .article .description {border:2px solid <?php echo bb_get_theme_mod('bb_colour6');?>; border-left:0; padding-top:0.5rem; box-shadow: 1px 1px 2px rgba(0,0,0,0.2);}
    .article .button.read-more {background-color: <?php echo bb_get_theme_mod('bb_colour5');?>; color:<?php echo bb_get_theme_mod('bb_colour1');?>; border-radius: 0; padding: 0.4rem 1.5rem; float: right; margin-right: 1rem; box-shadow: 1px 1px 2px rgba(0,0,0,0.2);}
}
@media only screen and (min-width: 40em) { /* <-- min-width 640px - medium screens and up */}
@media only screen and (min-width: 64em) { /* <-- min-width 1024px - large screens and up */}
</style>
<?php
$post = get_post($ID);
$image = bb_get_featured_image_url('medium',$ID);
$title = $post->post_title;
$content = $post->post_content;
$link = get_permalink($post);
?>
<div class="tile article cell" data-equalizer>
	<a href="<?php echo $link;?>">
		<div class="grid-x grid-padding-x">
            <span class="image small-8 medium-10 cell" style="background-image: url('<?php echo $image; ?>')" data-equalizer-watch></span>
            <span class="description small-16 medium-14 cell" data-equalizer-watch>
    	        <span class="title h4 text8"><?php echo $title; ?></span>
            	<span class="text8 blurb"><?php echo bb_extract($content, 100);?></span>
            </span>
        </div>
        <span class="button read-more"><em class="gf3">Read More</em></span>
    </a>
</div>