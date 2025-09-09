<?php
/**
 * Grant Insight Perfect - 1. Theme Setup File
 *
 * テーマの基本設定、スクリプト読込、ウィジェット、カスタマイザー、
 * パフォーマンス・セキュリティ最適化などを担当します。
 *
 * @package Grant_Insight_Perfect
 */

// セキュリティチェック
if (!defined('ABSPATH')) {
    exit;
}

/**
 * テーマセットアップ
 */
function gi_setup() {
    // テーマサポート追加
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('custom-background');
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    add_theme_support('menus');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    
    // RSS フィード
    add_theme_support('automatic-feed-links');
    
    // 画像サイズ追加
    add_image_size('gi-card-thumb', 400, 300, true);
    add_image_size('gi-hero-thumb', 800, 600, true);
    add_image_size('gi-tool-logo', 120, 120, true);
    add_image_size('gi-banner', 1200, 400, true);
    
    // 言語ファイル読み込み
    load_theme_textdomain('grant-insight', get_template_directory() . '/languages');
    
    // メニュー登録
    register_nav_menus(array(
        'primary' => 'メインメニュー',
        'footer' => 'フッターメニュー',
        'mobile' => 'モバイルメニュー'
    ));
}
add_action('after_setup_theme', 'gi_setup');

/**
 * コンテンツ幅設定
 */
function gi_content_width() {
    $GLOBALS['content_width'] = apply_filters('gi_content_width', 1200);
}
add_action('after_setup_theme', 'gi_content_width', 0);

/**
 * スクリプト・スタイルの読み込み（完全一元管理 - 重複排除版）
 */
function gi_enqueue_scripts() {
    // Tailwind CSS Play CDNはfunctions.phpで一度だけ読み込み
    // 重複を避けるため、条件付きで読み込み
    if (!wp_script_is('tailwind-cdn', 'registered')) {
        wp_register_script('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), GI_THEME_VERSION, false);
        
        // 統一されたTailwind設定
        $tailwind_config = gi_get_tailwind_config();
        wp_add_inline_script('tailwind-cdn', $tailwind_config);
    }
    
    // Tailwindをenqueue
    wp_enqueue_script('tailwind-cdn');
    
    // プリロード設定（パフォーマンス最適化）
    add_action('wp_head', function() {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link rel="preconnect" href="https://cdn.tailwindcss.com">' . "\n";
        echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//cdn.tailwindcss.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">' . "\n";
    }, 1);
    
    // Font Awesome CDN（一元管理）
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;600;700;800;900&display=swap', array(), null);
    
    // セキュリティヘッダーを追加
    add_action('wp_head', function() {
        echo '<meta http-equiv="X-Content-Type-Options" content="nosniff">' . "\n";
        echo '<meta http-equiv="X-Frame-Options" content="DENY">' . "\n";
        echo '<meta http-equiv="X-XSS-Protection" content="1; mode=block">' . "\n";
        echo '<meta name="referrer" content="strict-origin-when-cross-origin">' . "\n";
    }, 1);
    
    // テーマスタイル
    wp_enqueue_style('gi-style', get_stylesheet_uri(), array(), GI_THEME_VERSION);
    
    // メインJavaScript
    wp_enqueue_script('gi-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), GI_THEME_VERSION, true);
    
    // ブラウザキャッシュ制御
    add_action('wp_headers', function($headers) {
        $headers['Cache-Control'] = 'public, max-age=31536000';
        $headers['X-Content-Type-Options'] = 'nosniff';
        $headers['X-Frame-Options'] = 'DENY';
        $headers['X-XSS-Protection'] = '1; mode=block';
        return $headers;
    });
    
    // AJAX設定（強化版）
    wp_localize_script('gi-main-js', 'gi_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gi_ajax_nonce'),
        'homeUrl' => home_url('/'),
        'themeUrl' => get_template_directory_uri(),
        'uploadsUrl' => wp_upload_dir()['baseurl'],
        'isAdmin' => current_user_can('administrator'),
        'userId' => get_current_user_id(),
        'version' => GI_THEME_VERSION,
        'debug' => WP_DEBUG,
        'strings' => array(
            'loading' => '読み込み中...',
            'error' => 'エラーが発生しました',
            'noResults' => '結果が見つかりませんでした',
            'confirm' => '実行してもよろしいですか？'
        )
    ));
    // Back-compat shim for legacy inline scripts expecting giAjax
    wp_add_inline_script('gi-main-js', 'window.giAjax = window.giAjax || { ajaxurl: gi_ajax.ajax_url, nonce: gi_ajax.nonce };');
    
    // 条件付きスクリプト読み込み
    if (is_singular()) {
        wp_enqueue_script('comment-reply');
    }
    
    if (is_front_page()) {
        wp_enqueue_script('gi-frontend-js', get_template_directory_uri() . '/assets/js/front-page.js', array('gi-main-js'), GI_THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'gi_enqueue_scripts');


/**
 * ウィジェットエリア登録
 */
function gi_widgets_init() {
    register_sidebar(array(
        'name'          => 'メインサイドバー',
        'id'            => 'sidebar-main',
        'description'   => 'メインサイドバーエリア',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-8">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-lg font-semibold mb-4 pb-2 border-b-2 border-emerald-500">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => 'フッターエリア1',
        'id'            => 'footer-1',
        'description'   => 'フッター左側エリア',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title text-base font-semibold mb-3 text-white">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => 'フッターエリア2',
        'id'            => 'footer-2',
        'description'   => 'フッター中央エリア',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title text-base font-semibold mb-3 text-white">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => 'フッターエリア3',
        'id'            => 'footer-3',
        'description'   => 'フッター右側エリア',
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title text-base font-semibold mb-3 text-white">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'gi_widgets_init');

/**
 * カスタマイザー設定（強化版）
 */
function gi_customize_register($wp_customize) {
    // ヒーローセクション設定
    $wp_customize->add_section('gi_hero_section', array(
        'title' => 'ヒーローセクション',
        'priority' => 30,
        'description' => 'フロントページのヒーローセクションを設定します'
    ));
    
    // ヒーロータイトル
    $wp_customize->add_setting('gi_hero_title', array(
        'default' => 'AI が提案する助成金・補助金情報サイト',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_control('gi_hero_title', array(
        'label' => 'メインタイトル',
        'section' => 'gi_hero_section',
        'type' => 'text'
    ));
    
    // ヒーローサブタイトル
    $wp_customize->add_setting('gi_hero_subtitle', array(
        'default' => '最先端のAI技術で、あなたのビジネスに最適な助成金・補助金を瞬時に発見。',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_control('gi_hero_subtitle', array(
        'label' => 'サブタイトル',
        'section' => 'gi_hero_section',
        'type' => 'textarea'
    ));
    
    // ヒーロー動画
    $wp_customize->add_setting('gi_hero_video', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'gi_hero_video', array(
        'label' => 'ヒーロー動画',
        'section' => 'gi_hero_section',
        'mime_type' => 'video'
    )));
    
    // ヒーローロゴ
    $wp_customize->add_setting('gi_hero_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'gi_hero_logo', array(
        'label' => 'ヒーロー用ロゴ画像',
        'section' => 'gi_hero_section'
    )));
    
    // CTAボタン設定
    $wp_customize->add_setting('gi_hero_cta_primary_text', array(
        'default' => '今すぐ検索開始',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('gi_hero_cta_primary_text', array(
        'label' => 'プライマリCTAテキスト',
        'section' => 'gi_hero_section',
        'type' => 'text'
    ));
    
    $wp_customize->add_setting('gi_hero_cta_primary_url', array(
        'default' => '#search-section',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control('gi_hero_cta_primary_url', array(
        'label' => 'プライマリCTA URL',
        'section' => 'gi_hero_section',
        'type' => 'url'
    ));
    
    // サイト基本設定
    $wp_customize->add_section('gi_site_settings', array(
        'title' => 'サイト基本設定',
        'priority' => 25
    ));
    
    // プライマリカラー
    $wp_customize->add_setting('gi_primary_color', array(
        'default' => '#10b981',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gi_primary_color', array(
        'label' => 'プライマリカラー',
        'section' => 'gi_site_settings'
    )));
}
add_action('customize_register', 'gi_customize_register');


/**
 * パフォーマンス最適化
 */
function gi_performance_optimizations() {
    // 画像の遅延読み込み
    add_filter('wp_lazy_loading_enabled', '__return_true');
    
    // 不要なスクリプトの削除
    add_action('wp_enqueue_scripts', 'gi_dequeue_unnecessary_scripts', 100);
}
add_action('init', 'gi_performance_optimizations');

function gi_dequeue_unnecessary_scripts() {
    if (!is_admin()) {
        // 絵文字スクリプトの削除
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        
        // 未使用のスクリプトの削除
        if (!is_singular() || !comments_open()) {
            wp_dequeue_script('comment-reply');
        }
    }
}

/**
 * セキュリティ強化（テーマエディター有効版）
 */
function gi_security_enhancements() {
    // WordPressバージョンの隠蔽
    remove_action('wp_head', 'wp_generator');
    
    // 不要なヘッダー情報の削除
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // XMLRPCの無効化
    add_filter('xmlrpc_enabled', '__return_false');
    
    // ログイン試行回数の制限
    add_action('wp_login_failed', 'gi_login_failed');
    add_filter('authenticate', 'gi_check_login_attempts', 30, 3);
}
add_action('init', 'gi_security_enhancements');

/**
 * ログイン失敗の記録
 */
function gi_login_failed($username) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $attempts = get_option('gi_login_attempts', []);
    
    if (!isset($attempts[$ip])) {
        $attempts[$ip] = [];
    }
    
    $attempts[$ip][] = time();
    
    // 1時間以上前の試行を削除
    $attempts[$ip] = array_filter($attempts[$ip], function($time) {
        return $time > (time() - 3600);
    });
    
    update_option('gi_login_attempts', $attempts);
}

/**
 * ログイン試行チェック
 */
function gi_check_login_attempts($user, $username, $password) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $attempts = get_option('gi_login_attempts', []);
    
    if (isset($attempts[$ip]) && count($attempts[$ip]) >= 5) {
        return new WP_Error('too_many_attempts',  
            __('Too many login attempts. Please try again later.', 'grant-insight'));
    }
    
    return $user;
}