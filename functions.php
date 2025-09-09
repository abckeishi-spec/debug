<?php
/**
 * Grant Insight Perfect - Functions File Loader
 * @package Grant_Insight_Perfect
 */

// Security check
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('GI_THEME_VERSION', '7.0.0');
define('GI_THEME_PREFIX', 'gi_');

/**
 * Cached post count
 */
if (!function_exists('gi_get_cached_post_count')) {
    function gi_get_cached_post_count($post_type = 'post', $status = 'publish') {
        $cache_key = 'gi_post_count_' . $post_type . '_' . $status;
        $count = get_transient($cache_key);
        
        if ($count === false) {
            $posts = wp_count_posts($post_type);
            $count = isset($posts->$status) ? $posts->$status : 0;
            set_transient($cache_key, $count, HOUR_IN_SECONDS);
        }
        
        return $count;
    }
}

// Load feature files
$inc_dir = get_template_directory() . '/inc/';

require_once $inc_dir . '1-theme-setup.php';     // Theme setup and scripts
require_once $inc_dir . '2-post-types.php';      // Post types and taxonomies
require_once $inc_dir . '3-ajax-functions.php';  // AJAX functions
require_once $inc_dir . '4-helper-functions.php';// Helper functions
require_once $inc_dir . '5-template-tags.php';   // Template tags
require_once $inc_dir . '6-admin-functions.php'; // Admin functions
require_once $inc_dir . '7-acf-setup.php';       // ACF setup
require_once $inc_dir . '8-initial-setup.php';   // Initial setup

/**
 * テーマ設定取得関数（一元管理）
 */
if (!function_exists('gi_get_option')) {
    function gi_get_option($option_name, $default = '') {
        return get_theme_mod($option_name, $default);
    }
}

if (!function_exists('gi_get_sns_urls')) {
    function gi_get_sns_urls() {
        return [
            'twitter' => get_theme_mod('sns_twitter_url', ''),
            'facebook' => get_theme_mod('sns_facebook_url', ''),
            'linkedin' => get_theme_mod('sns_linkedin_url', ''),
            'instagram' => get_theme_mod('sns_instagram_url', ''),
            'youtube' => get_theme_mod('sns_youtube_url', '')
        ];
    }
}

/**
 * テーマの最終初期化
 */
function gi_final_init() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Grant Insight Theme v7.0.0: Initialization completed successfully');
    }
}
add_action('wp_loaded', 'gi_final_init', 999);

/**
 * Cleanup transients when switching themes
 */
function gi_theme_cleanup() {
    global $wpdb;
    
    // Delete all theme transients
    $sql = "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s";
    $wpdb->query($wpdb->prepare($sql, '_transient_gi_%', '_transient_timeout_gi_%'));
    
    // Delete theme options
    delete_option('gi_login_attempts');
    
    // Clear cache
    wp_cache_flush();
}
add_action('switch_theme', 'gi_theme_cleanup');