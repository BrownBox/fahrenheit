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
        jQuery("p#backtoblog a").attr("href", '<?php echo esc_js(site_url('/')); ?>').html('← Back to Better Marriages');
    });
</script>
<style>
html {background: none !important;}
html body.login {background-color: <?php echo bb_get_theme_mod('colour2'); ?>;}
body.login div#login h1 a {background-image: url(<?php echo bb_get_theme_mod(ns_.'logo_large')?>) !important; padding-bottom: 30px; margin: 0 auto; background-size: contain; width: 220px; height: 109px;}
body.login #login {width:520px;}
.login form {border-radius:3px; border:3px solid <?php echo bb_get_theme_mod('colour3'); ?>; -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none!important; position: relative; z-index: 1; background-color: white;}
body.login div#login form p label {color: <?php echo bb_get_theme_mod('colour6'); ?>; font-size:0.9rem;}
body.login #loginform p.submit .button-primary, body.wp-core-ui .button-primary {background-color: <?php echo bb_get_theme_mod('colour3'); ?> !important; font-size:14px; border: none !important; text-shadow: none; box-shadow: none;}
body.login #loginform p.submit .button-primary:hover, body.login #loginform p.submit .button-primary:focus, body.wp-core-ui .button-primary:hover {background-color: rgb(<?php bb_colour_lighter(bb_get_theme_mod('colour3')); ?>) !important;}
body.login div#login form .input, .login input[type="text"] {color: <?php echo bb_get_theme_mod('colour6'); ?>; font-size:1.25rem; -webkit-box-shadow: 0 0 0px 1000px white inset; -webkit-text-fill-color: <?php echo bb_get_theme_mod('colour6'); ?> !important;}
body.login #nav a, body.login #backtoblog a {color: <?php echo bb_get_theme_mod('colour6'); ?> !important;}
body.login #nav, body.login #backtoblog {text-shadow: none;}
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
