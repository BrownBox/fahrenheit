<?php
add_filter('login_redirect', 'bb_login_redirect', 10, 3);
function bb_login_redirect($redirect_to, $request, $user) {
    if (!is_wp_error($user) && !user_can($user, 'manage_options')) {
        return site_url('/');
    }
    return $redirect_to;
}

add_filter('admin_init', 'bb_admin_redirect', 10, 3);
function bb_admin_redirect() {
    if (!current_user_can('manage_options') && !wp_doing_ajax()) {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('wp_logout', 'bb_logout_redirect');
function bb_logout_redirect() {
    wp_redirect(site_url('/'));
}

add_filter('login_headerurl', 'bb_login_logo_url');
function bb_login_logo_url() {
    return site_url('/');
}

add_filter('login_headertitle', 'bb_login_logo_url_title');
function bb_login_logo_url_title() {
    return '';
}

add_action('login_footer', 'bb_login_footer');
function bb_login_footer() {
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("p#backtoblog a").attr("href", '<?php echo esc_js(site_url('/')); ?>').html('← Back to Home');
    });
</script>
<style>

body.login div#login h1 a {background-image: url(<?php echo bb_get_theme_mod(ns_.'logo_large')?>) !important; margin: 0 auto; background-size: contain; width: 220px; height: 109px;}

</style>
<?php
}

add_action('template_redirect', 'bb_redirect_login_page');
function bb_redirect_login_page() {
    if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        if (is_user_logged_in() && is_user_member_of_blog()) {
            wp_redirect(site_url('/'));
            exit;
        }
    }
}

add_action('wp_head', 'bb_hide_login_link');
function bb_hide_login_link() {
    if (is_user_logged_in()) {
        echo '<style>.login {display: none !important;}</style>'."\n";
    }
}
