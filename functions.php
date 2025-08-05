<?php
if (!defined('ABSPATH')) exit;

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
    register_post_type('person', array(
        'labels' => array(
            'name' => 'People',
            'singular_name' => 'Person',
        ),
        'public' => true,
        'has_archive' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-id',
        'supports' => array('title', 'thumbnail'),
    ));
}
add_action('init', 'register_people_cpt');