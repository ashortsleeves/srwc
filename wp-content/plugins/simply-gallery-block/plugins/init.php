<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$pgc_sgb_plugin_slug = 'pgc-simply-gallery-plugin';
$pgc_sgb_global_lightbox_use = false;
function pgc_sgb_plugin_init()
{
    global  $pgc_sgb_global_lightbox_use ;
    $pgc_sgb_global_lightbox_use = get_option( 'pgc_sgb_global_lightbox_use' );
    register_meta( 'post', 'pgc_sgb_lightbox_settings', array(
        'show_in_rest'      => true,
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback'     => function () {
        return current_user_can( 'edit_posts' );
    },
    ) );
}

function pgc_sgb_plugin_frontend_scripts()
{
    global  $post, $pgc_sgb_global_lightbox_use ;
    if ( is_404() || is_search() ) {
        return;
    }
    
    if ( $pgc_sgb_global_lightbox_use && is_object( $post ) && ($post->post_type === 'post' || $post->post_type === 'page') ) {
        $lightboxURL = plugins_url( '/plugins/pgc_sgb_lightbox.min.js', dirname( __FILE__ ) );
        $lightboxPreset = get_option( 'pgc_sgb_lightbox' );
        $field_value = get_post_meta( $post->ID, 'pgc_sgb_lightbox_settings', true );
        
        if ( $field_value !== '' ) {
            $field_value = json_decode( $field_value );
            if ( property_exists( $field_value, 'enableLightbox' ) ) {
                if ( $field_value->enableLightbox === false ) {
                    return;
                }
            }
        }
        
        global  $pgc_sgb_plugin_slug, $pgc_sgb_version ;
        wp_enqueue_script(
            $pgc_sgb_plugin_slug . '-lightbox-script',
            $lightboxURL,
            false,
            $pgc_sgb_version,
            true
        );
        $globalJS = array(
            'lightboxPreset'  => $lightboxPreset,
            'postType'        => $post->post_type,
            'lightboxSettigs' => $field_value,
        );
        wp_localize_script( $pgc_sgb_plugin_slug . '-lightbox-script', 'PGC_SGB_LIGHTBOX', $globalJS );
    }

}

function pgc_sgb_plugin_enqueue_assets()
{
    /** Block Editor - Global Lightbox Panel/Plugin */
    global 
        $post,
        $pgc_sgb_plugin_slug,
        $pgc_sgb_version,
        $pgc_sgb_plugin_dir,
        $pgc_sgb_global_lightbox_use
    ;
    if ( !$pgc_sgb_global_lightbox_use || $pgc_sgb_global_lightbox_use === false ) {
        return;
    }
    
    if ( is_object( $post ) && ($post->post_type === 'post' || $post->post_type === 'page') ) {
        wp_enqueue_style(
            $pgc_sgb_plugin_slug . '-editor',
            // Handle.
            plugins_url( 'dist/plugin.build.style.css', dirname( __FILE__ ) ),
            array( 'wp-components' ),
            $pgc_sgb_version
        );
        wp_enqueue_script(
            $pgc_sgb_plugin_slug . '-script',
            plugins_url( 'dist/plugin.build.js', dirname( __FILE__ ) ),
            array(
            'wp-plugins',
            'wp-edit-post',
            'wp-element',
            'wp-i18n',
            'wp-components',
            'wp-data'
        ),
            $pgc_sgb_version
        );
        $globalJS = array(
            'ajaxurl'        => admin_url( 'admin-ajax.php' ),
            'nonce'          => wp_create_nonce( 'pgc-sgb-nonce' ),
            'lightboxPreset' => get_option( 'pgc_sgb_lightbox' ),
            'globalLightbox' => $pgc_sgb_global_lightbox_use,
        );
        wp_localize_script( $pgc_sgb_plugin_slug . '-script', 'PGC_SGB_LIGHTBOX', $globalJS );
        if ( function_exists( 'wp_set_script_translations' ) ) {
            wp_set_script_translations( $pgc_sgb_plugin_slug . '-script', 'simply-gallery-block', $pgc_sgb_plugin_dir . '/languages' );
        }
    }

}

function pgc_sgb_plugin_options_assets()
{
    global 
        $pgc_sgb_plugin_slug,
        $pgc_sgb_version,
        $pgc_sgb_skins_presets,
        $pgc_sgb_plugin_dir,
        $pgc_sgb_global_lightbox_use,
        $user_ID
    ;
    wp_enqueue_style(
        $pgc_sgb_plugin_slug . '-page-settings',
        // Handle.
        plugins_url( 'dist/page.build.style.css', dirname( __FILE__ ) ),
        array( 'wp-components', 'code-editor' ),
        $pgc_sgb_version
    );
    wp_enqueue_script(
        $pgc_sgb_plugin_slug . '-page-settings-script',
        plugins_url( 'dist/page.build.js', dirname( __FILE__ ) ),
        array(
        'wp-api',
        'wp-element',
        'wp-i18n',
        'wp-components',
        'code-editor',
        'csslint'
    ),
        $pgc_sgb_version,
        true
    );
    $globalJS = array(
        'ajaxurl'        => admin_url( 'admin-ajax.php' ),
        'nonce'          => wp_create_nonce( 'pgc-sgb-nonce' ),
        'globalLightbox' => $pgc_sgb_global_lightbox_use,
        'lightboxPreset' => get_option( 'pgc_sgb_lightbox' ),
        'skinsSettings'  => $pgc_sgb_skins_presets,
        'is_multisite'   => is_multisite(),
        'is_super_admin' => is_super_admin( $user_ID ),
        'adminHTML'      => get_option( 'pgc_sgb_admin_unf_html' ),
        'editorHTML'     => get_option( 'pgc_sgb_editor_unf_html' ),
        'version'        => $pgc_sgb_version,
    );
    wp_localize_script( $pgc_sgb_plugin_slug . '-page-settings-script', 'PGC_SGB_OPTIONS_PAGE', $globalJS );
    if ( function_exists( 'wp_set_script_translations' ) ) {
        //wp_set_script_translations($pgc_sgb_plugin_slug . '-page-settings-script', 'simply-gallery-block', $pgc_sgb_plugin_dir . '/languages');
        wp_set_script_translations( $pgc_sgb_plugin_slug . '-page-settings-script', 'simply-gallery-block' );
    }
}

function pgc_sgb_plugin_admin_page()
{
    global  $pgc_sgb_plugin_slug ;
    echo  '<div id="' . $pgc_sgb_plugin_slug . '-settings-page"></div>' ;
}

function pgc_sgb_add_plugin_page_settings_link( $links )
{
    global  $pgc_sgb_plugin_slug ;
    $settings_link = '<a href="' . admin_url( 'options-general.php?page=' . $pgc_sgb_plugin_slug ) . '">Settings</a>';
    array_unshift( $links, $settings_link );
    return $links;
}

function pgc_sgb_plugin_activation( $plugin, $network_activation )
{
    
    if ( get_option( 'pgc_sgb_global_lightbox_use', null ) === null ) {
        add_option( 'pgc_sgb_global_lightbox_use', true );
        if ( $plugin == plugin_basename( 'simply-gallery-block/plugin.php' ) ) {
            exit( wp_redirect( admin_url( 'options-general.php?page=pgc-simply-gallery-plugin' ) ) );
        }
    }

}

function pgc_sgb_add_admin_page()
{
    global  $pgc_sgb_plugin_slug ;
    $page_hook_suffix = add_menu_page(
        'SimpLy Gallery',
        'SimpLy Gallery',
        'manage_options',
        $pgc_sgb_plugin_slug,
        'pgc_sgb_plugin_admin_page',
        'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI0IDI0OyIgdmVyc2lvbj0iMS4xIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMjJweCIgaGVpZ2h0PSIyMnB4IiB2aWV3Qm94PSIwIDAgMjk4LjczIDI5OC43MyIgZmlsbD0iIzAwODViYSIgZmlsbC1ydWxlPSJub256ZXJvIj48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZD0iTTI2NC45NTksOS4zNUgzMy43ODdDMTUuMTUzLDkuMzUsMCwyNC40OTgsMCw0My4xNTR2MjEyLjQ2MWMwLDE4LjYzNCwxNS4xNTMsMzMuNzY2LDMzLjc4NywzMy43NjYgICBoMjMxLjE3MWMxOC42MzQsMCwzMy43NzEtMTUuMTMyLDMzLjc3MS0zMy43NjZWNDMuMTU0QzI5OC43MywyNC40OTgsMjgzLjU5Myw5LjM1LDI2NC45NTksOS4zNXogTTE5My4xNzQsNTkuNjIzICAgYzE4LjAyLDAsMzIuNjM0LDE0LjYxNSwzMi42MzQsMzIuNjM0cy0xNC42MTUsMzIuNjM0LTMyLjYzNCwzMi42MzRjLTE4LjAyNSwwLTMyLjYzNC0xNC42MTUtMzIuNjM0LTMyLjYzNCAgIFMxNzUuMTQ5LDU5LjYyMywxOTMuMTc0LDU5LjYyM3ogTTI1NC4zNjMsMjU4LjE0OUgxNDkuMzYySDQ5LjAzOWMtOS4wMTMsMC0xMy4wMjctNi41MjEtOC45NjQtMTQuNTY2bDU2LjAwNi0xMTAuOTMgICBjNC4wNTgtOC4wNDQsMTEuNzkyLTguNzYyLDE3LjI2OS0xLjYwNWw1Ni4zMTYsNzMuNTk2YzUuNDc3LDcuMTU4LDE1LjA1LDcuNzY3LDIxLjM4NiwxLjM1NGwxMy43NzctMTMuOTUxICAgYzYuMzMxLTYuNDEzLDE1LjY1OS01LjYxOSwyMC44MjYsMS43NjJsMzUuNjc1LDUwLjk1OUMyNjYuNDg3LDI1Mi4xNiwyNjMuMzc2LDI1OC4xNDksMjU0LjM2MywyNTguMTQ5eiI+PC9wYXRoPjwvZz48L3N2Zz4=',
        '11.9'
    );
    add_action( "admin_print_scripts-{$page_hook_suffix}", 'pgc_sgb_plugin_options_assets' );
}

add_action( 'admin_menu', 'pgc_sgb_add_admin_page' );
function pgc_sgb_plugin_lightbox_options_assets()
{
    global 
        $pgc_sgb_plugin_slug,
        $pgc_sgb_version,
        $pgc_sgb_skins_presets,
        $pgc_sgb_global_lightbox_use
    ;
    wp_enqueue_style(
        $pgc_sgb_plugin_slug . '-lightbox-page-settings',
        // Handle.
        plugins_url( 'dist/lightbox.page.build.style.css', dirname( __FILE__ ) ),
        array( 'wp-components' ),
        $pgc_sgb_version
    );
    wp_enqueue_script(
        $pgc_sgb_plugin_slug . '-lightbox-page-settings-script',
        plugins_url( 'dist/lightbox.page.build.js', dirname( __FILE__ ) ),
        array(
        'wp-api',
        'wp-element',
        'wp-i18n',
        'wp-components'
    ),
        $pgc_sgb_version,
        true
    );
    $globalJS = array(
        'ajaxurl'        => admin_url( 'admin-ajax.php' ),
        'nonce'          => wp_create_nonce( 'pgc-sgb-nonce' ),
        'globalLightbox' => $pgc_sgb_global_lightbox_use,
        'lightboxPreset' => get_option( 'pgc_sgb_lightbox' ),
        'version'        => $pgc_sgb_version,
    );
    wp_localize_script( $pgc_sgb_plugin_slug . '-lightbox-page-settings-script', 'PGC_SGB_OPTIONS_PAGE', $globalJS );
    if ( function_exists( 'wp_set_script_translations' ) ) {
        wp_set_script_translations( $pgc_sgb_plugin_slug . '-lightbox-page-settings-script', 'simply-gallery-block' );
    }
}

function pgc_sgb_plugin_lightbox_admin_page()
{
    global  $pgc_sgb_plugin_slug ;
    echo  '<div id="' . $pgc_sgb_plugin_slug . '-lightbox-page"></div>' ;
}

function pgc_sgb_add_lightbox_admin_page()
{
    global  $pgc_sgb_plugin_slug ;
    $pr_sub_page_lightbox_hook_suffix = add_submenu_page(
        $pgc_sgb_plugin_slug,
        'SimpLy Lightbox',
        'Lightbox Settigs',
        'manage_options',
        $pgc_sgb_plugin_slug . '-lightbox-options',
        'pgc_sgb_plugin_lightbox_admin_page'
    );
    add_action( "admin_print_scripts-{$pr_sub_page_lightbox_hook_suffix}", 'pgc_sgb_plugin_lightbox_options_assets' );
}

add_action( 'admin_menu', 'pgc_sgb_add_lightbox_admin_page' );
add_filter( 'plugin_action_links_simply-gallery-block/plugin.php', 'pgc_sgb_add_plugin_page_settings_link' );
add_action( 'init', 'pgc_sgb_plugin_init' );
add_action( 'enqueue_block_editor_assets', 'pgc_sgb_plugin_enqueue_assets' );
add_action( 'wp_enqueue_scripts', 'pgc_sgb_plugin_frontend_scripts' );
add_action(
    'activated_plugin',
    'pgc_sgb_plugin_activation',
    1,
    2
);