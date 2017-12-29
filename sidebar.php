<?php
global $post;

// Get current page's children
/*$menu_items = get_posts(
        array(
                'posts_per_page'   => 20,
                'orderby'          => 'menu_order, title',
                'order'            => 'ASC',
                'post_type'        => 'page',
                'post_parent'      => $post->ID,
        )
);

if (empty($menu_items)) { // No children, get siblings
    $menu_items = get_posts(
            array(
                    'posts_per_page'   => 20,
                    'orderby'          => 'menu_order, title',
                    'order'            => 'ASC',
                    'post_type'        => 'page',
                    'post_parent'      => $post->post_parent,
            )
    );
}

echo '<ul>'."\n";
foreach ($menu_items as $item) {
    echo '<li>'."\n";
    echo '<a href="'.get_permalink($item->ID).'">'.$item->post_title.'</a>'."\n";
    echo '</li>'."\n";
}
echo '</ul>'."\n";*/
$args = array(
    'posts_per_page'   => 1,
    'orderby'          => 'rand',
    'order'            => 'DESC',
    'post_type'        => array('post', 'stories'),
);

$posts = get_posts($args);
foreach ($posts as $post){
    echo get_card('card=post-preview&ID='.$post->ID);
}
echo get_card('card=CTA&ID=362');
echo get_card('card=smarty-grants&ID=720');
echo get_card('addthis-share');


?>

