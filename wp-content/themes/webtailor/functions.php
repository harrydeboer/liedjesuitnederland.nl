<?php
/**
 *  1 Algemeen
 */


// 1.1.1 Queue styles
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', PHP_INT_MAX);
function theme_enqueue_styles(): void {
    wp_enqueue_style( 'bootstrap-style', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' , array(), '4.3.1' );
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Barlow:400,500|Bree+Serif&display=swap', array(), '1.0');
    wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/app.css', array(), '1.0.7' );
}

// 1.1.2 Queue scripts
function theme_enqueue_scripts(): void {
    wp_register_script('fontawesome', '//kit.fontawesome.com/7f1c8d490d.js', array(), '1.0', false);
    wp_register_script(
        'main',
        get_stylesheet_directory_uri() .
        '/assets/js/main.js', array('jquery'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
    wp_register_script('bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' , array('jquery'), '4.3.1', true);
    wp_enqueue_script('fontawesome');
    wp_enqueue_script('main');
    wp_enqueue_script('bootstrap');
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

// 1.2.1 Add theme support for Featured Images & Title tag for yoast
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

// 1.2.2 add custom image sizes 
add_action( 'after_setup_theme', 'custom_image_sizes' );
function custom_image_sizes(): void {
    add_image_size( 'thumb', 120 );
}
//1.2.3 disable automatic big image resizing by WP
//add_filter( 'big_image_size_threshold', '__return_false' );

// 1.2.4 add svg to media library
function add_file_types_to_uploads($file_types): array {
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';

    return array_merge($file_types, $new_filetypes );
}
add_action('upload_mimes', 'add_file_types_to_uploads');

// 1.2.5 Enable svg for Fontawesome
function script_add_attribute($tag, $handle) {
    if ( 'fontawesome' !== $handle )
        return $tag;
    return str_replace( ' src', 'data-search-pseudo-elements defer src', $tag );
}
add_filter('script_loader_tag', 'script_add_attribute', 10, 2);

// 1.2.6 change wp excerpt length
function custom_excerpt_length(): int {
    return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// 1.3.1 Add main menu
function register_my_menu(): void {
    register_nav_menu('header-menu',__( 'Header menu' ));
    register_nav_menu('footer-menu',__( 'Footer menu' ));

}
add_action( 'init', 'register_my_menu' );


// 1.3.2 add sub-menu icons
/** @noinspection PhpUnusedParameterInspection */
function prefix_add_button_after_menu_item_children($item_output, $item, $depth, $args ): string {
    $menus = array(
        'header-menu',
        'footer-menu'
    );

    if ( in_array($args->theme_location, $menus) ) {

        if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
            $item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><div class="submenu-icon"><svg class="svg-inline--fa fa-chevron-down fa-w-14" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M443.5 162.6l-7.1-7.1c-4.7-4.7-12.3-4.7-17 0L224 351 28.5 155.5c-4.7-4.7-12.3-4.7-17 0l-7.1 7.1c-4.7 4.7-4.7 12.3 0 17l211 211.1c4.7 4.7 12.3 4.7 17 0l211-211.1c4.8-4.7 4.8-12.3.1-17z"></path></svg></div>', $item_output );
        }
    }

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_add_button_after_menu_item_children', 10, 4 );

// 1.3.3 Add options page for ACF
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'  => 'Thema instellingen',
        'menu_title'  => 'Thema instellingen',
        'position' => 0,
        'menu_slug'   => 'thema-instellingen',
        'capability'  => 'edit_posts',
        'redirect'    => false
    ));
}

/**
 * 2 CPT Video
 */
// 2.1 Register periode as taxonomy
function periode_register_taxonomies(): void {
    $labels = array(
        'name' => __( 'Periode', 'video_cpt' ),
        'label' => __( 'Periode', 'video_cpt' ),
        'add_new_item' => __( 'Voeg periode toe', 'video_cpt' ),
    );
    $args = array(
        'labels' => $labels,
        'label' => __( 'Periode', 'video_cpt' ),
        'show_ui' => true,
        'show_admin_column' => true,
        'hierarchical' => true,
        'has_archive' => false
    );
    register_taxonomy( 'periode', array( 'video' ), $args );
}
add_action( 'init', 'periode_register_taxonomies' );

// 2.2 Register thema as taxonomy
function thema_register_taxonomies(): void {
    $labels = array(
        'name' => __( 'Thema', 'video_cpt' ),
        'label' => __( 'Thema', 'video_cpt' ),
        'add_new_item' => __( 'Voeg thema toe', 'video_cpt' ),
    );
    $args = array(
        'labels' => $labels,
        'label' => __( 'Thema', 'video_cpt' ),
        'show_ui' => true,
        'show_admin_column' => true,
        'hierarchical' => true,
        'has_archive' => false
    );
    register_taxonomy( 'thema', array( 'video' ), $args );
}
add_action( 'init', 'thema_register_taxonomies' );

// 2.3 Add Custom post_type Video
function video_cpt(): void {
    $labels = array(
        'name' => __( 'Video\'s', 'video_cpt' ),
        'singular_name' => __( 'Video', 'video_cpt' ),
        'all_items' => __( 'Alle video\'s', 'video_cpt' ),
        'menu_name' => __( 'Video\'s', 'video_cpt' ),
        'view_item' => __( 'Bekijk video', 'video_cpt' ),
        'add_new_item' => __( 'Nieuwe video toevoegen', 'video_cpt' ),
        'add_new' => __( 'Nieuwe video toevoegen', 'video_cpt' ),
        'edit_item' => __( 'Video bijwerken', 'video_cpt' ),
        'update_item' => __( 'Video bijwerken', 'video_cpt' ),
        'search_items' => __( 'Video zoeken', 'video_cpt' ),
        'not_found' => __( 'Geen video gevonden', 'video_cpt' ),

    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive' => false,
        'map_meta_cap' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'menu_position' => 7,
        'supports' => array( 'title', 'author', 'thumbnail' )
    );
    register_post_type( 'video', $args );

    if (isset($_REQUEST['_sf_s'])
        || isset($_REQUEST['_sft_periode'])
        || isset($_REQUEST['_sft_thema'])
        || isset($_REQUEST['scroll-videos-ajax'])) {
        require_once(__DIR__ . '/autoload.php');
    }
}
add_action( 'init', 'video_cpt' );

// 2.4 Redirect all single videos to video page
add_action( 'template_redirect', 'redirect_video' );
function redirect_video(): void {
    if ( is_singular('video') ) {
        $redirectLink = '/';
        wp_redirect( $redirectLink, 301 );
        exit;
    }
}
