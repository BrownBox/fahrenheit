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
$post = get_post($ID);
echo '<li class="cell card card-'.$ID.'">'."\n";
$image = bb_get_featured_image_url('medium',$ID);
if(empty($image)) $image = bb_get_theme_mod(ns_.'logo_small');
$url = get_permalink($ID);
echo '  <a class="wrapper '.$class.'" href="'.$url.'">'."\n";
echo '      <div class="grid-x grid-padding-x">'."\n";
echo '          <div class="small-8 medium-6 large-6 cell background-image relative" style="min-height:85px; background-image: url('.$image.');" title="'.$post->post_title.'">'."\n";
$count = 0;
$count += substr_count(strtolower($post->post_title), strtolower($string));
$count += substr_count(strtolower($post->post_content), strtolower($string));
echo '              <span class="count absolute">'.$count.'x</span>'."\n";
echo '              <span class="post_type absolute">'.$post->post_type.'</span>'."\n";
unset($count);
echo '          </div>'."\n";
echo '          <div class="small-16 medium-18 large-18 cell content">'."\n";
$content .= '              <p class="title">'.$post->post_title.'</p>'."\n";
$content .= '              <p>'.strip_tags(bb_extract(strip_shortcodes($post->post_content), 300)).'</p>'."\n";
$content = str_replace(strtoupper($string), '<span class="highlight">'.strtoupper($string).'</span>', $content);
$content = str_replace(strtolower($string), '<span class="highlight">'.strtolower($string).'</span>', $content);
$content = str_replace(ucfirst($string), '<span class="highlight">'.ucfirst($string).'</span>', $content);
echo $content;
echo '          </div>'."\n";
echo '      </div>'."\n";
echo '  </a>'."\n";
echo '</li>'."\n";
