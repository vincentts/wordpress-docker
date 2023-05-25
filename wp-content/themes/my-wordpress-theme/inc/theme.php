<?php

add_action( 'after_setup_theme', 'theme_functions' );
function theme_functions() {
    add_theme_support( 'title-tag' );
}

remove_action( 'wp_head', 'wp_generator' );
remove_action ('wp_head', 'rsd_link' );

add_action( 'wp_enqueue_scripts', function() {
    $site_styles = [ 'main' ];
    $site_scripts = [];

    foreach( $site_styles as $style ) {
        enqueue_style( $style, false );
    }

    // foreach( $site_scripts as $script => $options ) {
    //     enqueue_script( $script, $options );
    // }
} );

add_filter( 'style_loader_tag', 'preload_css', 10, 4 );
add_filter( 'script_loader_tag', 'defer_js_parsing', 10, 2 );