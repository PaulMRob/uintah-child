<?php
if (!defined('ABSPATH')) exit;

// Load custom widgets
require_once get_stylesheet_directory() . '/widgets/class-carousel-widget.php';
require_once get_stylesheet_directory() . '/widgets/class-feature-grid-widget.php';
require_once get_stylesheet_directory() . '/widgets/class-banner-mid-widget.php';


add_action('wp_enqueue_scripts', 'astra_child_enqueue_styles');
function astra_child_enqueue_styles() {
    wp_enqueue_style(
        'astra-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['astra-parent-style'],
        wp_get_theme()->get('Version')
    );
}
function register_people_cpt() {
    register_post_type('people', array(
        'labels' => array(
            'name' => 'People',
            'singular_name' => 'Person',
        ),
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => array('title', 'editor', 'thumbnail'),
    ));
}
add_action('init', 'register_people_cpt');

function child_theme_enqueue_scripts() {
    wp_enqueue_script(
        'child-scroll-buttons',
        get_stylesheet_directory_uri() . '/js/scroll-buttons.js',
        array(), 
        null,    
        true     
    );
}
add_action('wp_enqueue_scripts', 'child_theme_enqueue_scripts');


// Register widget areas for homepage sections
function astra_child_register_home_widgets() {
    $sections = [
        'carousel-section'       => 'Carousel Section',
        'feature-grid-section'   => 'Feature Grid Section',
        'banner-mid-section'     => 'Banner Mid Section',
        'carousel-alt-section'   => 'Carousel Alt Section',
    ];

    foreach ( $sections as $id => $name ) {
        register_sidebar( array(
            'name'          => __( $name, 'astra-child' ),
            'id'            => $id,
            'description'   => __( "Widgets for the {$name} on the homepage.", 'astra-child' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
}
add_action( 'widgets_init', 'astra_child_register_home_widgets' );
