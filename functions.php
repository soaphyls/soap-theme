<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme Setup
 */
function soaptheme_setup() {

    // Allow WordPress to manage the document title tag
    add_theme_support( 'title-tag' );

    // Enable post thumbnails (featured images)
    add_theme_support( 'post-thumbnails' );

    // Tell WordPress this theme supports HTML5 markup
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Elementor: enable full-width page template support
    add_theme_support( 'elementor' );

    // WooCommerce Support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register a primary navigation menu (optional)
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'soap-theme' ),
    ] );
}
add_action( 'after_setup_theme', 'soaptheme_setup' );


/**
 * Enqueue theme stylesheet
 * The style.css is required by WordPress to recognise the theme.
 * It carries no actual styles so it costs nothing.
 */
function soaptheme_scripts() {
    wp_enqueue_style(
        'soap-theme-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'soaptheme_scripts' );


/**
 * Remove WordPress default block styles (Gutenberg)
 * Prevents WP's built-in block CSS from leaking into Elementor pages
 */
function soaptheme_remove_block_styles() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'classic-theme-styles' ); // WP 6.1+
    wp_dequeue_style( 'global-styles' );         // WP 6.1+
}
add_action( 'wp_enqueue_scripts', 'soaptheme_remove_block_styles', 100 );


/**
 * Remove the default WordPress emoji scripts & styles
 * Lightweight choice — emoji will fall back to OS-native rendering
 */
function soaptheme_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'soaptheme_disable_emojis' );


/**
 * Remove WooCommerce Sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
