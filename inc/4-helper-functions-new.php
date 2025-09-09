<?php
/**
 * Helper functions
 * @package Grant_Insight_Perfect
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Cached post count
 */
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

/**
 * Safe excerpt with length limit
 */
function gi_safe_excerpt($text, $length = 160) {
    if (empty($text)) return '';
    
    $text = strip_tags($text);
    $text = mb_substr($text, 0, $length, 'UTF-8');
    $text = rtrim($text);
    
    return $text;
}

/**
 * Get formatted deadline
 */
function gi_get_formatted_deadline($post_id) {
    $deadline = get_post_meta($post_id, 'deadline_date', true);
    
    if (!$deadline) {
        $deadline = get_post_meta($post_id, 'deadline', true);
    }
    
    if (!$deadline) {
        return '';
    }
    
    if (is_numeric($deadline)) {
        return date('Y年m月d日', intval($deadline));
    }
    
    return esc_html($deadline);
}