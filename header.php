<?php
/**
 * The header for our theme
 * @package Grant_Insight_Perfect
 */

if (!defined('ABSPATH')) {
    exit;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
        $description = is_singular() 
            ? gi_safe_excerpt(get_the_excerpt(), 160) 
            : get_bloginfo('description');
    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>">
    
    <!-- Open Graph / Twitter Card -->
    <?php if (is_singular()) : ?>
        <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>">
        <meta property="og:description" content="<?php echo esc_attr(gi_safe_excerpt(get_the_excerpt(), 160)); ?>">
        <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>">
        <meta property="og:description" content="<?php echo esc_attr(gi_safe_excerpt(get_the_excerpt(), 160)); ?>">
        <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large')); ?>">
        <?php endif; ?>
    <?php else : ?>
        <meta property="og:title" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
        <meta property="og:description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
        <meta property="og:url" content="<?php echo esc_url(home_url()); ?>">
    <?php endif; ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    
    <?php wp_head(); ?>
    
    <!-- 追加のTailwind設定（functions.phpの設定を拡張） -->
    <script>
        // functions.phpのTailwind設定を拡張
        if (typeof tailwind !== 'undefined' && tailwind.config) {
            // ヘッダー専用の追加設定
            const headerConfig = {
                theme: {
                    extend: {
                        ...tailwind.config.theme.extend,
                        zIndex: {
                            'header': '1000',
                            'mobile-menu': '1050',
                            'overlay': '1040'
                        },
                        backdropBlur: {
                            'header': '12px'
                        }
                    }
                }
            };
            
            // 設定をマージ
            Object.assign(tailwind.config.theme.extend, headerConfig.theme.extend);
        }
    </script>
</head>
<body <?php body_class('bg-gray-50 text-gray-900 antialiased'); ?>>
    
    <!-- WordPressフック -->
    <?php wp_body_open(); ?>
    
    <!-- スキップリンク -->
    <a class="skip-link sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-header transition-all duration-200" href="#content">
        <?php esc_html_e('メインコンテンツへスキップ', 'grant-insight'); ?>
    </a>

    <?php
    // カスタマイザー設定の取得
    $header_layout = gi_get_option('gi_header_layout', 'default');
    $show_search = gi_get_option('gi_header_show_search', false);
    $header_container_classes = 'container mx-auto px-4 py-4 flex items-center';

    switch ($header_layout) {
        case 'centered':
            $header_container_classes .= ' justify-center';
            break;
        case 'minimal':
            $header_container_classes .= ' justify-between';
            break;
        default:
            $header_container_classes .= ' justify-between';
            break;
    }
    ?>

    <!-- メインヘッダー（ゴージャス版） -->
    <header class="header-main sticky top-0 bg-gradient-to-r from-white via-blue-50/90 to-indigo-50/90 backdrop-blur-xl shadow-xl border-b border-gradient-to-r from-blue-200 to-purple-200 z-header animate-fade-in-down" role="banner" aria-label="Main header">
        <!-- Decorative background pattern -->
        <div class="absolute inset-0 opacity-5" aria-hidden="true">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-600/10 via-transparent to-purple-600/10"></div>
            <div class="absolute top-2 left-10 w-32 h-32 bg-gradient-to-br from-yellow-400/20 to-orange-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-2 right-10 w-24 h-24 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="relative <?php echo esc_attr($header_container_classes); ?>">
            
            <!-- 強化されたサイトロゴ -->
            <div class="site-logo flex-shrink-0 animate-scale-in">
                <div class="logo-wrapper group relative">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="flex items-center space-x-4">
                        
                        <!-- ロゴコンテナ -->
                        <div class="logo-container relative">
                            <!-- メインロゴ -->
                            <div class="logo-main relative z-10">
                                <img src="https://joseikin-insight.com/wp-content/uploads/2025/09/1757335941511.png" 
                                     alt="助成金・補助金インサイト" 
                                     class="h-14 md:h-16 w-auto drop-shadow-xl group-hover:drop-shadow-2xl transition-all duration-500 group-hover:scale-110">
                            </div>
                            
                            <!-- ロゴの輝きエフェクト -->
                            <div class="logo-glow absolute inset-0 rounded-full bg-gradient-to-r from-yellow-400/30 via-orange-400/30 to-red-400/30 blur-xl scale-150 opacity-0 group-hover:opacity-100 transition-all duration-700 animate-pulse-gentle"></div>
                            
                            <!-- 回転する装飾リング -->
                            <div class="decoration-ring absolute inset-0 border-2 border-dashed border-blue-400/40 rounded-full scale-125 opacity-0 group-hover:opacity-60 group-hover:rotate-180 transition-all duration-1000"></div>
                        </div>
                        
                        <!-- 強化されたサイトタイトル -->
                        <div class="site-title-enhanced">
                            <div class="title-main">
                                <h1 class="text-2xl md:text-3xl font-black bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 bg-clip-text text-transparent tracking-tight leading-none group-hover:from-blue-700 group-hover:via-purple-600 group-hover:to-indigo-700 transition-all duration-500">
                                    助成金・補助金
                                </h1>
                                <div class="subtitle flex items-center space-x-2 mt-1">
                                    <span class="text-xl md:text-2xl font-bold text-gray-700 group-hover:text-gray-800 transition-colors duration-300">インサイト</span>
                                    <div class="badge bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md group-hover:shadow-lg transition-all duration-300 animate-bounce-gentle hidden md:block">
                                        NEW
                                    </div>
                                </div>
                            </div>
                            <p class="tagline text-sm text-gray-600 mt-2 font-medium group-hover:text-blue-600 transition-colors duration-300 hidden md:block">
                                <i class="fas fa-sparkles mr-1 text-yellow-500"></i>
                                あなたの成功への第一歩をサポート
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- デスクトップナビゲーション -->
            <nav class="desktop-nav hidden lg:flex items-center space-x-1 animate-fade-in-up" 
                 style="animation-delay: 0.2s;" 
                 role="navigation" 
                 aria-label="メインナビゲーション"
                 aria-expanded="false">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '<ul id="menu-primary-navigation" class="flex items-center space-x-1" role="menubar" aria-label="メインナビゲーション">%3$s</ul>',
                        'depth'          => 2,
                        'link_before'    => '<span role="menuitem" tabindex="0">',
                        'link_after'     => '</span>',
                        'fallback_cb'    => false,
                    ]);
                } else { ?>
                        'walker'         => class_exists('Custom_Nav_Walker') ? new Custom_Nav_Walker() : null,
                    ]);
                } else {
                    // フォールバック: 基本的なメニューを表示
                    ?>
                    <ul class="flex items-center space-x-1">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>" 
                               class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium <?php echo is_front_page() ? 'active text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-home mr-2 text-sm"></i>
                                ホーム
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/grants/')); ?>" 
                               class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium <?php echo is_post_type_archive('grant') || is_singular('grant') ? 'active text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-money-bill-wave mr-2 text-sm"></i>
                                助成金一覧
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/tools/')); ?>" 
                               class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium <?php echo is_post_type_archive('tool') || is_singular('tool') ? 'active text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-tools mr-2 text-sm"></i>
                                ツール
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/case-studies/')); ?>" 
                               class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium <?php echo is_post_type_archive('case_study') || is_singular('case_study') ? 'active text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-trophy mr-2 text-sm"></i>
                                成功事例
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/guides/')); ?>" 
                               class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium <?php echo is_post_type_archive('guide') || is_singular('guide') ? 'active text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-book mr-2 text-sm"></i>
                                ガイド
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" 
                               class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium <?php echo is_page('contact') ? 'active text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-envelope mr-2 text-sm"></i>
                                お問い合わせ
                            </a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
                
                <!-- ヘッダー検索（オプション） -->
                <?php if ($show_search) : ?>
                <div class="header-search ml-4">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
                        <input type="search" 
                               name="s" 
                               value="<?php echo esc_attr(get_search_query()); ?>"
                               placeholder="助成金を検索..."
                               class="w-64 px-4 py-2 pr-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               aria-label="助成金検索">
                        <button type="submit" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600"
                                aria-label="検索実行">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                
                <!-- CTAボタン -->
                <div class="ml-6">
                    <?php
                    $cta_text = gi_get_option('gi_header_cta_text', '無料相談');
                    $cta_url = gi_get_option('gi_header_cta_url', home_url('/contact/'));
                    ?>
                    <a href="<?php echo esc_url($cta_url); ?>" 
                       class="cta-button inline-flex items-center bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600 text-white py-2.5 px-6 rounded-full font-bold text-sm shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 group animate-pulse-gentle"
                       aria-label="<?php echo esc_attr($cta_text . 'ページへ移動'); ?>">
                        <i class="fas fa-comments mr-2 group-hover:animate-bounce-gentle" aria-hidden="true"></i>
                        <span style="color: #ffffff !important;"><?php echo esc_html($cta_text); ?></span>
                    </a>
                </div>
            </nav>
            
            <!-- モバイルメニューボタン -->
            <div class="mobile-menu-toggle flex items-center lg:hidden animate-fade-in-up" style="animation-delay: 0.3s;">
                <button id="mobile-menu-button" 
                        class="menu-button p-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 transform hover:scale-110 active:scale-95 z-mobile-menu"
                        aria-label="メニューを開く"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        role="button"
                        tabindex="0"
                        type="button">
                    <i class="fas fa-bars text-xl" aria-hidden="true"></i>
                    <span class="sr-only">メニューを開く</span>
                </button>
            </div>
        </div>
    </header>

    <!-- モバイルメニューオーバーレイ -->
    <div id="mobile-menu-overlay" 
         class="mobile-overlay fixed inset-0 bg-black bg-opacity-50 z-overlay hidden opacity-0 transition-opacity duration-300"
         aria-hidden="true"></div>

    <!-- モバイルメニュー -->
    <aside id="mobile-menu" 
           class="mobile-menu fixed top-0 right-0 w-80 max-w-full h-full bg-white shadow-2xl z-mobile-menu transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto"
           aria-label="モバイルナビゲーション"
           aria-hidden="true">
        
        <!-- メニューヘッダー -->
        <div class="menu-header flex items-center justify-between p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="menu-title flex items-center space-x-3">
                <!-- モバイルメニュー内のロゴ -->
                <img src="https://page.gensparksite.com/v1/base64_upload/d9d00699dd79e7ea2cbbf0914b07084a" 
                     alt="助成金・補助金インサイト" 
                     class="h-8 w-auto">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">メニュー</h2>
                    <p class="text-sm text-gray-600">助成金・補助金インサイト</p>
                </div>
            </div>
            <button id="mobile-menu-close-button" 
                    class="close-button p-2 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 transform hover:scale-110 active:scale-95"
                    aria-label="メニューを閉じる"
                    type="button"
                    tabindex="0"
                    role="button">
                <i class="fas fa-times text-xl" aria-hidden="true"></i>
                <span class="sr-only">メニューを閉じる</span>
            </button>
        </div>

        <!-- メニューコンテンツ -->
        <div class="menu-content p-6">
            <!-- ナビゲーションメニュー -->
            <nav class="mobile-navigation mb-8" role="navigation" aria-label="モバイルメインナビゲーション">
                <?php
                // モバイル専用メニューがあればそれを、なければプライマリメニューを流用
                if (has_nav_menu('mobile')) {
                    wp_nav_menu([
                        'theme_location' => 'mobile',
                        'container'      => false,
                        'items_wrap'     => '<ul class="nav-list space-y-2">%3$s</ul>',
                        'depth'          => 1,
                    ]);
                } elseif (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '<ul class="nav-list space-y-2">%3$s</ul>',
                        'depth'          => 1,
                    ]);
                } else {
                    // フォールバック: 基本的なメニューを表示
                    ?>
                    <ul class="nav-list space-y-2">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_front_page() ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-home w-5 text-center mr-3 text-blue-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                ホーム
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/grants/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_post_type_archive('grant') || is_singular('grant') ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-money-bill-wave w-5 text-center mr-3 text-green-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                助成金一覧
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/tools/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_post_type_archive('tool') || is_singular('tool') ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-tools w-5 text-center mr-3 text-purple-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                ツール
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/case-studies/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_post_type_archive('case_study') || is_singular('case_study') ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-trophy w-5 text-center mr-3 text-yellow-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                成功事例
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/guides/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_post_type_archive('guide') || is_singular('guide') ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-book w-5 text-center mr-3 text-indigo-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                ガイド・解説
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/grant-tips/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_post_type_archive('grant_tip') || is_singular('grant_tip') ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-lightbulb w-5 text-center mr-3 text-orange-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                申請のコツ
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" 
                               class="nav-item flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium group <?php echo is_page('contact') ? 'text-blue-600 bg-blue-50' : ''; ?>">
                                <i class="fas fa-envelope w-5 text-center mr-3 text-red-500 group-hover:scale-110 transition-transform" aria-hidden="true"></i>
                                お問い合わせ
                            </a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </nav>
            
            <!-- モバイル検索（オプション） -->
            <?php if ($show_search) : ?>
            <div class="mobile-search mb-6">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
                    <input type="search" 
                           name="s" 
                           value="<?php echo esc_attr(get_search_query()); ?>"
                           placeholder="助成金を検索..."
                           class="w-full px-4 py-3 pr-12 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           aria-label="助成金検索">
                    <button type="submit" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600"
                            aria-label="検索実行">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <?php endif; ?>
            
            <!-- CTAボタン -->
            <div class="cta-section mb-8">
                <a href="<?php echo esc_url($cta_url); ?>" 
                   class="cta-button block w-full text-center bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600 text-white py-4 px-6 rounded-xl font-bold text-base shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 group"
                   aria-label="<?php echo esc_attr($cta_text . 'ページへ移動'); ?>">
                    <i class="fas fa-comments mr-2 group-hover:animate-bounce-gentle" aria-hidden="true"></i>
                    <span style="color: #ffffff !important;"><?php echo esc_html($cta_text . 'を始める'); ?></span>
                </a>
            </div>

            <!-- 追加情報 -->
            <div class="additional-info pt-6 border-t border-gray-100">
                <div class="info-grid grid grid-cols-2 gap-4 text-center">
                    <div class="info-item bg-blue-50 rounded-lg p-4 hover:bg-blue-100 transition-colors">
                        <div class="info-icon text-2xl text-blue-600 mb-2" aria-hidden="true">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-label text-xs text-gray-600 font-medium">お電話</div>
                        <div class="info-value text-sm text-gray-800 font-semibold">平日 9-18時</div>
                    </div>
                    <div class="info-item bg-green-50 rounded-lg p-4 hover:bg-green-100 transition-colors">
                        <div class="info-icon text-2xl text-green-600 mb-2" aria-hidden="true">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-label text-xs text-gray-600 font-medium">営業時間</div>
                        <div class="info-value text-sm text-gray-800 font-semibold">月〜金 9-18時</div>
                    </div>
                </div>
                
                <!-- サイト情報 -->
                <div class="site-info mt-6 text-center text-xs text-gray-500">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                    <?php if (gi_get_option('gi_privacy_policy_url')) : ?>
                        <p class="mt-2">
                            <a href="<?php echo esc_url(gi_get_option('gi_privacy_policy_url')); ?>" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                プライバシーポリシー
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </aside>

    <!-- メインコンテンツ開始 -->
    <main id="content" class="site-main" role="main">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 要素の取得
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenuCloseButton = document.getElementById('mobile-menu-close-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    
    // メニュー状態の管理
    let isMenuOpen = false;

    // メニューを開く関数
    function openMobileMenu() {
        if (!mobileMenu || !mobileMenuOverlay) return;
        
        isMenuOpen = true;
        
        // オーバーレイを表示
        mobileMenuOverlay.classList.remove('hidden');
        mobileMenuOverlay.setAttribute('aria-hidden', 'false');
        setTimeout(() => {
            mobileMenuOverlay.classList.remove('opacity-0');
            mobileMenuOverlay.classList.add('opacity-100');
        }, 10);
        
        // メニューをスライドイン
        mobileMenu.classList.remove('translate-x-full');
        mobileMenu.classList.add('translate-x-0');
        
        // ボディのスクロールを無効化
        document.body.style.overflow = 'hidden';
        
        // ARIA属性を更新
        mobileMenuButton.setAttribute('aria-expanded', 'true');
        mobileMenu.setAttribute('aria-hidden', 'false');
        
        // フォーカスをメニューに移動
        mobileMenuCloseButton.focus();
        
        // フォーカストラップ
        trapFocus(mobileMenu);
    }

    // メニューを閉じる関数
    function closeMobileMenu() {
        if (!mobileMenu || !mobileMenuOverlay || !isMenuOpen) return;
        
        isMenuOpen = false;
        
        // メニューをスライドアウト
        mobileMenu.classList.remove('translate-x-0');
        mobileMenu.classList.add('translate-x-full');
        
        // オーバーレイをフェードアウト
        mobileMenuOverlay.classList.remove('opacity-100');
        mobileMenuOverlay.classList.add('opacity-0');
        
        setTimeout(() => {
            mobileMenuOverlay.classList.add('hidden');
            mobileMenuOverlay.setAttribute('aria-hidden', 'true');
        }, 300);
        
        // ボディのスクロールを有効化
        document.body.style.overflow = '';
        
        // ARIA属性を更新
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        mobileMenu.setAttribute('aria-hidden', 'true');
        
        // フォーカスをボタンに戻す
        mobileMenuButton.focus();
        
        // フォーカストラップを解除
        removeFocusTrap();
    }

    // フォーカストラップ機能
    let focusableElements = [];
    let firstFocusableElement = null;
    let lastFocusableElement = null;

    function trapFocus(element) {
        focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        firstFocusableElement = focusableElements[0];
        lastFocusableElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', handleFocusTrap);
    }

    function removeFocusTrap() {
        if (mobileMenu) {
            mobileMenu.removeEventListener('keydown', handleFocusTrap);
        }
    }

    function handleFocusTrap(e) {
        if (e.key === 'Tab') {
            if (e.shiftKey) {
                if (document.activeElement === firstFocusableElement) {
                    lastFocusableElement.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastFocusableElement) {
                    firstFocusableElement.focus();
                    e.preventDefault();
                }
            }
        }
    }

    // イベントリスナーの追加
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileMenu();
        });
    }

    if (mobileMenuCloseButton) {
        mobileMenuCloseButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenu();
        });
    }

    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    }

    // ESCキーでメニューを閉じる
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMobileMenu();
        }
    });

    // ウィンドウサイズがPC幅になったら、開いているメニューを閉じる
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024 && isMenuOpen) {
            closeMobileMenu();
        }
    });

    // メニュー内のリンクをクリックしたらメニューを閉じる
    const mobileNavLinks = mobileMenu?.querySelectorAll('a');
    if (mobileNavLinks) {
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                // 少し遅延を入れてメニューを閉じる
                setTimeout(closeMobileMenu, 200);
            });
        });
    }
    
    // スムーズスクロール（アンカーリンク用）
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const headerHeight = document.querySelector('.header-main').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ヘッダーのスクロール効果
    let lastScrollY = window.scrollY;
    const header = document.querySelector('.header-main');
    let ticking = false;
    
    function updateHeader() {
        const currentScrollY = window.scrollY;
        
        // スクロール方向によってヘッダーの表示/非表示を制御
        if (currentScrollY > 100) {
            if (currentScrollY > lastScrollY && !isMenuOpen) {
                // 下にスクロール：ヘッダーを隠す（メニューが開いていない場合のみ）
                header.style.transform = 'translateY(-100%)';
            } else {
                // 上にスクロール：ヘッダーを表示
                header.style.transform = 'translateY(0)';
            }
        } else {
            // トップ付近：常に表示
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollY = currentScrollY;
        ticking = false;
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
        }
    });
    
    // ロード完了時のアニメーション遅延設定
    const animatedElements = document.querySelectorAll('.animate-fade-in-up, .animate-scale-in');
    animatedElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });

    // パフォーマンス監視
    if ('requestIdleCallback' in window) {
        requestIdleCallback(function() {
            // アイドル時間中に実行する軽い処理
            console.log('Header initialized successfully');
        });
    }
});
</script>

<!-- ゴージャススタイル（完全版） -->
<style>
/* ロゴ関連の強化スタイル */
.logo-container {
    perspective: 1000px;
}

.logo-main {
    transform-style: preserve-3d;
    transition: transform 0.6s cubic-bezier(0.4, 0.0, 0.2, 1);
}

.logo-wrapper:hover .logo-main {
    transform: rotateY(5deg) rotateX(5deg);
}

/* グラデーション境界線 */
.border-gradient-to-r {
    border-image: linear-gradient(90deg, #3B82F6, #8B5CF6) 1;
}

/* 装飾的なアニメーション */
@keyframes bounce-gentle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-2px); }
}

.animate-bounce-gentle {
    animation: bounce-gentle 2s infinite;
}

@keyframes pulse-gentle {
    0%, 100% { opacity: 0.8; }
    50% { opacity: 0.4; }
}

.animate-pulse-gentle {
    animation: pulse-gentle 3s infinite;
}

/* ナビゲーションリンクのカスタムスタイル */
.nav-link {
    position: relative;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -2px;
    left: 50%;
    background: linear-gradient(90deg, #3B82F6, #8B5CF6);
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 80%;
}

/* ヘッダーのトランジション */
.header-main {
    transition: transform 0.3s ease;
}

/* ホバーエフェクト強化 */
.site-logo:hover {
    filter: drop-shadow(0 10px 30px rgba(59, 130, 246, 0.3));
}

/* モバイルメニューのカスタムスタイル */
.mobile-menu {
    box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
}

/* z-indexカスタムクラス */
.z-header { z-index: 1000; }
.z-mobile-menu { z-index: 1050; }
.z-overlay { z-index: 1040; }

/* バックドロップブラー */
.backdrop-blur-header {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

/* フォーカス状態の強化 */
button:focus-visible,
a:focus-visible {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
    border-radius: 4px;
}

/* スキップリンクのスタイル */
.skip-link {
    transform: translateY(-100%);
    transition: transform 0.3s ease;
}

.skip-link:focus {
    transform: translateY(0);
}

/* アクセシビリティ用の非表示クラス */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.focus\:not-sr-only:focus {
    position: static;
    width: auto;
    height: auto;
    padding: inherit;
    margin: inherit;
    overflow: visible;
    clip: auto;
    white-space: normal;
}

/* レスポンシブ調整 */
@media (max-width: 768px) {
    .logo-container {
        transform: scale(0.9);
    }
    
    .decoration-ring {
        display: none;
    }
}

@media (max-width: 640px) {
    .mobile-menu {
        width: 100vw;
    }
}

/* アニメーション調整 */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    
    .header-main {
        transition: none !important;
    }
    
    .logo-glow,
    .decoration-ring,
    .animate-bounce-gentle,
    .animate-pulse-gentle {
        animation: none !important;
        transition: none !important;
    }
}

/* 高解像度ディスプレイ対応 */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .mobile-menu {
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.15);
    }
}

/* カスタムアニメーション */
@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translate3d(0, -100%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translate3d(0, 100%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

@keyframes scale-in {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.6s ease-out;
}

.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out;
}

.animate-scale-in {
    animation: scale-in 0.6s ease-out;
}
</style>