<?php
// Enable featured images
add_theme_support('post-thumbnails');

// Enable RSS support
add_theme_support('automatic-feed-links');

// Automatically include title tag
add_theme_support('title-tag');

// Enable HTML for the search form
add_theme_support('html5', array('search-form'));

// Add filters
add_filter('wp_title', array('bb_theme', 'title'), 10, 2);
add_filter('template_include', array('bb_theme', 'template_name'), 9999);
add_filter('automatic_updater_disabled', '__return_true');

// Add actions
add_action('admin_bar_menu', array('bb_theme', 'custom_adminbar'), 999);
add_action('widgets_init', array('bb_theme', 'register_widgets'));
add_action('admin_init', array('bb_theme', 'imagelink_default'));
add_action('wp_footer', array('bb_theme', 'lazy_load_script'));
add_action('wp_ajax_bb_lazy_load', array('bb_theme', 'ajax_lazy_load_section'));
add_action('wp_ajax_nopriv_bb_lazy_load', array('bb_theme', 'ajax_lazy_load_section'));

// Shortcodes
add_shortcode('list_posts', array('bb_theme', 'list_posts'));

// The master class
class bb_theme {
    static $lazy_load_sections = array();

    static function section($args) {
        is_array($args) ? extract($args) : parse_str($args);

        // check for required variables
        if (!isset($name) || (!isset($file) && !isset($content))) {
            return;
        }
        if (!isset($class)) {
            $class = 'no-class'; // other options include 'fluid' and 'full' or any custom classes for outer wrapper
        }
        if (!isset($grid_type)) {
            $grid_type = 'grid-x grid-margin-x'; // other options include 'grid-y', 'grid-padding-x', etc
        }
        if (!isset($inner_class)) {
            $inner_class = ''; // custom classes for inner wrapper
        }
        if (!isset($type)) {
            $type = 'div'; // could be any block-level HTML element
        }
        if (!isset($dir)) {
            $dir = 'sections';
        }
        if (isset($lazy_load) && $lazy_load == true) {
            $inner_class .= ' lazy-load';
        }

        // setup the wrapper
        echo "\n".'<!-- '.$name.' -->'."\n";
        echo "\n".'<!-- '.$file.' -->'."\n";
        echo '<'.$type.' '.$style.' id="row-'.$name.'" class="grid-container '.$class.'">'."\n";
        echo '    <div id="row-inner-'.$name.'" class="'.$grid_type.' '.$inner_class.'" data-section_name="'.$file.'">'."\n";

        if (isset($file) && $file != false) {
            $template_details = array(
                    'directory' => $dir,
                    'file' => $file
            );

            if (isset($lazy_load) && $lazy_load == true) {
                echo '<p class="text-center"><i class="fas fa-3x fa-spin fa-spinner"></i></p>' . "\n";
                self::$lazy_load_sections[$name] = $template_details;
            } else {
                self::load_section($template_details);
            }
        }

        if (isset($content) && $file == false) {
            echo $content;
        }

        echo '    </div>'."\n";
        echo '</'.$type.'>'."\n";
        echo '<!-- end '.$name.' -->'."\n";
    }

    static private function load_section($template_details) {
        $matched_section = locate_template(array(implode('/',  $template_details)), true);

        // Check if request section was found in a theme
        if (!$matched_section) {
            // Apply filter that may overwrite the location of tempalte
            $template_details = apply_filters('bb_theme_section_template', $template_details);

            // Check if custom template was located
            if (isset($template_details['custom_location'])) {
                require $template_details['directory'].$template_details['file'];
            }
        }
    }

    static function ajax_lazy_load_section() {
        $filename = basename($_POST['filename']);
        $template_details = array(
                'directory' => 'sections',
                'file' => $filename,
        );
        self::load_section($template_details);
        die();
    }

    static function lazy_load_script() {
        if (!empty(self::$lazy_load_sections)) {
?>
    <script>
        var lazy_loaded = false;
        jQuery(document).ready(function() {
            bb_lazy_load_sections();
            jQuery(document).scroll(function() {
                bb_lazy_load_sections();
            });
        });
        function bb_lazy_load_sections() {
            if (!lazy_loaded && jQuery(window).scrollTop() >= 250) {
                lazy_loaded = true;
                jQuery('div.row-inner-wrapper.lazy-load').each(function() {
                    var section = jQuery(this);
                    var filename = section.data('section_name');
                    jQuery.post(ajaxurl, {
                        action: 'bb_lazy_load',
                        filename: filename
                    }, function(data) {
                        section.html(data);
                    });
                });
            }
        }
    </script>
<?php
        }
    }

    /**
     * Generate list of posts (e.g. for an archive page)
     * @param array|string $args
     * @return string
     * @todo rebuild using cards framework
     */
    static function list_posts($args) {
        is_array($args) ? extract($args) : parse_str($args);

//         if (!isset($layout)) {
            $layout = 'default';
//         }
        if (!isset($outer_element)) {
            $outer_element = 'ul';
        }
        if (!isset($inner_element)) {
            $inner_element = 'li';
        }
        if (!isset($type)) {
            $type = 'post'; // any valid post type
        }

        $final_content = '<div class="grid-container">'."\n";
        if (post_type_exists($type)) {
            $args = array(
                    'post_type' => $type,
                    'posts_per_page' => -1,
            );
            $posts = get_posts($args);
            if (count($posts) > 0) {
                switch ($layout) {
                    case 'accordion': // @todo
                        break;
                    case 'tabs': // @todo
                        break;
                    default:
                        $no_images = array();

                        // Primary items (ones with a featured image)
                        $final_content .= '<'.$outer_element.' class="bb_posts_wrapper grid-x grid-margin-x small-up-1 medium-up-2 large-up-3">'."\n";
                        foreach ($posts as $item) {
                            if (!has_post_thumbnail($item->ID)) {
                                $no_images[] = $item;
                                continue;
                            }
                            $final_content .= '  <'.$inner_element.' class="bb_posts_item cell">'."\n";
                            if (!empty($item->post_content)) {
                                $final_content .= '    <a href="'.get_the_permalink($item).'">'."\n";
                            }
                            $image = get_value_from_hierarchy('featured_image', $item->ID);
                            $final_content .= '      <img src="'.$image.'">'."\n";
                            $final_content .= $item->post_title."\n";
                            if (!empty($item->post_content)) {
                                $final_content .= '    </a>';
                            }
                            $final_content .= '  </'.$inner_element.'>'."\n";
                        }
                        $final_content .= '</'.$outer_element.'>'."\n";

                        // Secondary items (no image)
                        if (count($no_images) > 0) {
                            $final_content .= '<'.$outer_element.' class="bb_posts_subwrapper">'."\n";
                            foreach ($no_images as $item) {
                                $final_content .= '  <'.$inner_element.' class="bb_posts_subitem">'."\n";
                                if (!empty($item->post_content)) {
                                    $final_content .= '    <a href="'.get_the_permalink($item).'">'."\n";
                                }
                                $final_content .= $item->post_title."\n";
                                if (!empty($item->post_content)) {
                                    $final_content .= '    </a>';
                                }
                                $final_content .= '  </'.$inner_element.'>'."\n";
                            }
                            $final_content .= '</'.$outer_element.'>'."\n";
                        }
                        break;
                }
            }
        }
        $final_content .= '</div>'."\n";

        return $final_content;
    }

    /**
     * Generate series of helper CSS classes for the page wrapper based on the page content
     * @param string $classes Custom classes to include
     * @param boolean $post_atts Whether to include post slug and ID classes
     * @return string
     */
    static function classes($classes = '', $post_atts = true) {
        global $post;
        $class = array();

        $class[] = $args;
        $class[] = (is_archive())       ? '' : 'not-archive';
        $class[] = (is_attachment())    ? 'attachment' : 'not-attachment';
        $class[] = (is_front_page())    ? '' : 'not-home';
        $class[] = (is_home())          ? '' : 'not-blog';
        $class[] = (is_page())          ? '' : 'not-page';
        $class[] = (is_search())        ? '' : 'not-search';
        $class[] = (is_single())        ? '' : 'not-single';
        $class[] = (is_sticky())        ? 'sticky' : 'not-sticky';
        $class[] = (is_tax())           ? 'tax' : 'not-tax';
        if ($post_atts == true) {
            $class[] = $post->post_type.'-'.$post->post_name;
        }

        $class = implode(' ', $class);
        return $class;
    }

    /**
     * Generates a Zurb Interchange HTML element
     * @see http://foundation.zurb.com/sites/docs/interchange.html
     * @param array|string $args
     * @param boolean $echo
     * @return void|string
     */
    static function interchange($args, $echo = true) {
        is_array($args) ? extract($args) : parse_str($args);
        if (!$small || !$medium || !$large ) {
            return;
        }
        if (empty($element)) {
            $element = 'img';
        }

        $html = '<'.$element.' data-interchange="['.$small.', small], ['.$medium.', medium], ['.$large.', large]" src="'.$large.'"';
        if (!empty($attrs)) {
            if (is_array($attrs)) {
                $attr_string = '';
                foreach ($attrs as $attr => $value) {
                    $attr_string .= ' '.$attr.'="'.$value.'"';
                }
            } else {
                $attr_string = $attrs;
            }
            $html .= ' '.$attr_string;
        }
        $html .= '>';
        if ($echo) {
            echo $html."\n";
        } else {
            return $html;
        }
    }

    /**
     * Generates an image element with srcset attribute
     * @param array|string $args {
     *     @type string     $src    Primary/fallback image source. Required.
     *     @type string     $s      Image source for small screens. Defaults to value of $src.
     *     @type string     $m      Image source for medium screens. Defaults to value of $src.
     *     @type string     $l      Image source for large screens. Defaults to value of $src.
     *     @type boolean    $echo   Whether to echo the result. Default true.
     *     @type string     $id     Value of id attribute. Default is a randomly generated string.
     *     @type string     $alt    Value of alt attribute. Default empty.
     * }
     * @return string HTML image element if $echo is false, else null.
     */
    static function srcset($args) {
        $defaults = array(
                'id' => wp_generate_password(8, false),
                'alt' => '',
                'echo' => true,
        );
        $args = wp_parse_args($args, $defaults);

        if (empty($args['s'])) {
            $args['s'] = $args['src'];
        }
        if (empty($args['m'])) {
            $args['m'] = $args['src'];
        }
        if (empty($args['l'])) {
            $args['l'] = $args['src'];
        }

        $img = '<img id='.$args['id'].' src="'.$args['src'].'" srcset="'.$args['s'].' 639w, '.$args['m'].' 1024w, '.$args['l'].' 1600w" alt="'.$args['alt'].'">';
        if ($echo) {
            echo $img;
        } else {
            return $img;
        }
    }

    static function onclick($args) {
        $defaults = array(
                'echo' => true,
        );
        extract(wp_parse_args($args, $defaults));

        $location = empty($target) ? "location.href='$url';" : "window.open('$url','$target');";
        if ($echo) {
            echo $location;
        } else {
            return $location;
        }
    }

    static function title($title, $sep) {
        global $paged, $page;
        if (is_feed()) {
            return $title;
        }

        // Add the site name.
        $title .= get_bloginfo('name');

        // Add the site description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) {
            $title = "$title $sep $site_description";
        }
        // Add a page number if necessary.
        if ($paged >= 2 || $page >= 2) {
            $title = "$title $sep " . sprintf(__('Page %s', THEME_TEXTDOMAIN), max($paged, $page));
        }
        return $title;
    }

    static function setup_data($file, $term = MEDIUM_TERM) {
        global $post;
        $filename = str_replace(get_stylesheet_directory(), '', $file);
        $t_args = array('name' => 'var_'.$post->ID, 'file' => $filename);
        $transient_name = BB_Transients::name($t_args);
        if (!BB_Transients::use_transients()) {
            delete_transient($transient_name);
        }
        if (false === ($var = get_transient($transient_name))) {
            $var = array(
                    'file' => $filename,
                    'meta' => array(),
                    'ancestors' => array(),
                    'ancestor_string' => '',
                    'archive_page' => null,
                    'transient_suffix' => '',
            );

            if (is_search()) {
                $var['transient_suffix'] .= '_search';
                $var['search_string'] = $_GET['s'];
            }

            if (is_singular()) {
                $var['meta'] = bb_get_post_meta($post->ID);
                $var['ancestors'] = get_ancestors($post->ID, get_post_type($post));
                if (!empty($var['ancestors'])) {
                    $var['ancestor_string'] .= '_'.implode('_', $ancestors);
                }
                $var['transient_suffix'] .= $var['ancestor_string'].'_'.$post->ID;
            }

            if (is_archive()) {
                $var['transient_suffix'] .= '_'.get_query_var('post_type');
                $var['archive_page'] = get_page_by_path(get_query_var('post_type'));
                $var['meta'] = bb_get_post_meta($var['archive_page']->ID);
            } elseif (is_home() && !is_front_page()) {
                $var['transient_suffix'] .= '_post';
                $var['archive_page'] = get_option('page_for_posts', true);
                $var['meta']= bb_get_post_meta($var['archive_page']);
            }

            set_transient($transient_name, $var, $term);
        }

        return $var;
    }

    static function custom_adminbar($wp_admin_bar) {
        // Environment indicator
        if (!defined('WP_BB_ENV')) {
            define('WP_BB_ENV', 'DEVELOPMENT');
        }

        switch (strtoupper(WP_BB_ENV)) {
            case 'PRODUCTION':
                $class = 'prod';
                break;
            case 'STAGING':
                $class = 'stage';
                break;
            case 'DEVELOPMENT':
            default:
                $class = 'dev';
                break;
        }

        $args = array(
                'id' => 'bb-env',
                'title' => strtoupper(WP_BB_ENV),
                'meta' => array(
                        'class' => 'bb '.$class,
                ),
        );
        $wp_admin_bar->add_node($args);

        // State indicator
        if (!defined('WP_BB_STATE')) {
            define('WP_BB_STATE', 'WIP');
        }
        switch (strtoupper(WP_BB_STATE)) {
            case 'STABLE':
                $class = 'stable';
                break;
            case 'WIP':
                $class = 'wip';
                break;
            case 'BROKEN':
            default:
                $class = 'broken';
                break;
        }

        $args = array(
                'id' => 'bb-state',
                'title' => strtoupper(WP_BB_STATE),
                'meta' => array(
                        'class' => 'bb '.$class,
                ),
        );
        $wp_admin_bar->add_node($args);

        $refresh_link = is_admin() ? '/?bb=refresh' : '?bb=refresh';
        $args = array(
                'id' => 'bb-css',
                'title' => 'Refresh',
                'href' => $refresh_link,
                'meta' => array(
                        'class' => 'bb css',
                ),
        );
        $wp_admin_bar->add_node($args);
        if (isset($_GET['bb']) && $_GET['bb'] == 'refresh') {
            bb_update_dynamic_styles();
            $transients = new BB_Transients();
            $transients->delete();
        }
    }

    static function register_widgets() {
//         register_sidebar(array(
//                 'name' => 'Example Widget',
//                 'id' => 'example_widget',
//                 'before_widget' => '',
//                 'after_widget' => '',
//                 'before_title' => '<h1>',
//                 'after_title' => '</h1>',
//         ));
    }

    static function template_name($t) {
        if (current_user_can('manage_options')) {
            $template_name = get_page_template_slug(get_queried_object_id());
            if (empty($template_name)) {
                $template_name = '(default)';
            }
            $template_name = basename($t).' > '.$template_name;
            add_action('wp_footer', function($arg) use ($template_name) {echo '<div id="template-name">'.$template_name.'</div>'."\n";});
        }
        return $t;
    }

    static function imagelink_default() {
        if (get_option('image_default_link_type') !== 'none') {
            update_option('image_default_link_type', 'none');
        }
    }
}
