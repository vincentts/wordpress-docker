<?php

/** 
 * @param array $custom_options
 * - register - set to true to register script, default to enqueue_script
 * - src - used only for external script source
 * - version - used only for external script source
 * - dependencies - dependencies of script
 * - in_footer - place script in footer
 * - localize - use wp_localize_script - array of [ "object_name" => data ]
 * - attr - 'defer' or 'async'
 */
function enqueue_script( string $js_name, array $custom_options = [] ) {
    $dependency_key = 'js/' . $js_name . '.js';

    $default_options = [
        'register' => false,
        'src' => get_stylesheet_directory_uri() . '/assets/js/' . $js_name . '.js',
        'version' => ! empty( $custom_options['src'] ) ? null : ASSETS[$dependency_key]['version'],
        'dependencies' => ! empty( $custom_options['src'] ) ? null : ASSETS[$dependency_key]['dependencies'],
        'in_footer' => false,
        'localize' => null,
        'attr' => '',
    ];

    $options = array_merge( $default_options, $custom_options );

    if ( $options['register'] ) {
        wp_register_script( $js_name, $options['src'], $options['dependencies'], $options['version'], $options['in_footer'] );
        return;
    }

    wp_enqueue_script( $js_name, $options['src'], $options['dependencies'], $options['version'], $options['in_footer'] );

    if ( $options['attr'] !== '' ) {
        wp_script_add_data( $js_name, 'attr', $options['attr'] );
    }

    if ( $options['localize'] ) {
        foreach( $options['localize'] as $object_name => $data ) {
            wp_localize_script( $js_name, $object_name, $data );
        }
    }
}

/** 
* @param array $custom_options
* - src - used only for external CSS source
* - version - used only for external CSS source
* - dependencies - dependencies of CSS
*/
function enqueue_style( string $css_name, bool $preload = true, array $custom_options = [] ) {
    $dependency_key = 'css/' . $css_name . '.js';
    $default_options = [
        'src' => get_stylesheet_directory_uri() . '/assets/css/' . $css_name . '.css',
        'version' => ! empty( $custom_options['src'] ) ? null : ASSETS[$dependency_key]['version'],
        'dependencies' => ! empty( $custom_options['src'] ) ? null : ASSETS[$dependency_key]['dependencies'],
    ];

    $options = array_merge( $default_options, $custom_options );
    wp_enqueue_style( $css_name, $options['src'], $options['dependencies'], $options['version'] );
    wp_style_add_data( $css_name, 'preload', $preload );
}

function defer_js_parsing( $tag, $handle ) {
    if ( wp_scripts()->get_data( $handle, 'attr' )  ) {
        $attr = wp_scripts()->get_data( $handle, 'attr' );
        $tag = str_replace( " src", " $attr src", $tag );
    }

    return $tag;
}

function preload_css( $tag, $handle, $href, $media ) {
    if ( wp_styles()->get_data( $handle, 'preload' ) ) {
        $tag = str_replace( "<link rel='stylesheet'", "<link rel='preload' as='style' onload='this.rel=\"stylesheet\"'", $tag );
    }

    return $tag;
}