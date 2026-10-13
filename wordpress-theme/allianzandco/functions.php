<?php
/**
 * Allianz & Co – theme bootstrap.
 *
 * @package AllianzAndCo
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'AL_THEME_VERSION', '1.0.0' );
define( 'AL_THEME_DIR', get_template_directory() );
define( 'AL_THEME_URI', get_template_directory_uri() );

/* =========================================================================
 * 1. Theme setup
 * ======================================================================= */
if ( ! function_exists( 'al_setup' ) ) :
function al_setup() {
    load_theme_textdomain( 'allianzandco', AL_THEME_DIR . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'editor-styles' );

    // Image sizes
    add_image_size( 'al-project',    800, 600, true );
    add_image_size( 'al-project-lg', 1600, 1100, true );
    add_image_size( 'al-team',       600, 800, true );
    add_image_size( 'al-blog',       900, 600, true );

    // Nav menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'allianzandco' ),
        'footer'  => esc_html__( 'Footer Menu',  'allianzandco' ),
    ) );
}
endif;
add_action( 'after_setup_theme', 'al_setup' );

/* =========================================================================
 * 2. Enqueue assets
 * ======================================================================= */
function al_enqueue_assets() {
    // Google Fonts: Space Grotesk + Inter + Playfair Display
    wp_enqueue_style(
        'al-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;1,500&family=Space+Grotesk:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Base / main
    wp_enqueue_style(
        'al-main',
        AL_THEME_URI . '/assets/css/main.css',
        array( 'al-fonts' ),
        AL_THEME_VERSION
    );

    // style.css (theme header metadata, also a small fallback)
    wp_enqueue_style(
        'al-style',
        get_stylesheet_uri(),
        array( 'al-main' ),
        AL_THEME_VERSION
    );

    // Scripts
    wp_enqueue_script(
        'al-main',
        AL_THEME_URI . '/assets/js/main.js',
        array(),
        AL_THEME_VERSION,
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'al_enqueue_assets' );

/* =========================================================================
 * 3. Custom Post Types: Team, FAQ
 * ======================================================================= */
function al_register_post_types() {
    // Team
    register_post_type( 'al_team', array(
        'labels' => array(
            'name'               => esc_html__( 'Team', 'allianzandco' ),
            'singular_name'      => esc_html__( 'Team Member', 'allianzandco' ),
            'add_new_item'       => esc_html__( 'Add New Member', 'allianzandco' ),
            'edit_item'          => esc_html__( 'Edit Member', 'allianzandco' ),
            'all_items'          => esc_html__( 'All Members', 'allianzandco' ),
            'menu_name'          => esc_html__( 'Team', 'allianzandco' ),
        ),
        'public'              => true,
        'has_archive'         => false,
        'show_in_rest'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'team', 'with_front' => false ),
    ) );

    // FAQ
    register_post_type( 'al_faq', array(
        'labels' => array(
            'name'          => esc_html__( 'FAQs', 'allianzandco' ),
            'singular_name' => esc_html__( 'FAQ', 'allianzandco' ),
            'add_new_item'  => esc_html__( 'Add New FAQ', 'allianzandco' ),
            'edit_item'     => esc_html__( 'Edit FAQ', 'allianzandco' ),
            'all_items'     => esc_html__( 'All FAQs', 'allianzandco' ),
            'menu_name'     => esc_html__( 'FAQs', 'allianzandco' ),
        ),
        'public'              => true,
        'has_archive'         => false,
        'show_in_rest'        => true,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-editor-help',
        'supports'            => array( 'title', 'editor', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'faqs', 'with_front' => false ),
    ) );

    // Services (for the Services page listing)
    register_post_type( 'al_service', array(
        'labels' => array(
            'name'          => esc_html__( 'Services', 'allianzandco' ),
            'singular_name' => esc_html__( 'Service', 'allianzandco' ),
            'add_new_item'  => esc_html__( 'Add New Service', 'allianzandco' ),
            'edit_item'     => esc_html__( 'Edit Service', 'allianzandco' ),
            'all_items'     => esc_html__( 'All Services', 'allianzandco' ),
            'menu_name'     => esc_html__( 'Services', 'allianzandco' ),
        ),
        'public'              => true,
        'has_archive'         => false,
        'show_in_rest'        => true,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-hammer',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'services', 'with_front' => false ),
    ) );

    // Projects / portfolio (for homepage featured projects)
    register_post_type( 'al_project', array(
        'labels' => array(
            'name'          => esc_html__( 'Projects', 'allianzandco' ),
            'singular_name' => esc_html__( 'Project', 'allianzandco' ),
            'add_new_item'  => esc_html__( 'Add New Project', 'allianzandco' ),
            'edit_item'     => esc_html__( 'Edit Project', 'allianzandco' ),
            'all_items'     => esc_html__( 'All Projects', 'allianzandco' ),
            'menu_name'     => esc_html__( 'Projects', 'allianzandco' ),
        ),
        'public'              => true,
        'has_archive'         => false,
        'show_in_rest'        => true,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'projects', 'with_front' => false ),
    ) );
}
add_action( 'init', 'al_register_post_types' );

/* =========================================================================
 * 4. Taxonomies
 * ======================================================================= */
function al_register_taxonomies() {
    register_taxonomy( 'al_project_cat', 'al_project', array(
        'labels' => array(
            'name'          => esc_html__( 'Project Categories', 'allianzandco' ),
            'singular_name' => esc_html__( 'Project Category', 'allianzandco' ),
        ),
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => array( 'slug' => 'project-category' ),
    ) );
}
add_action( 'init', 'al_register_taxonomies' );

/* =========================================================================
 * 5. Meta boxes (lightweight, no ACF required)
 * ======================================================================= */
function al_meta_boxes() {
    add_meta_box( 'al_team_details', __( 'Team Member Details', 'allianzandco' ), 'al_team_meta_box', 'al_team', 'normal', 'high' );
    add_meta_box( 'al_project_details', __( 'Project Details', 'allianzandco' ), 'al_project_meta_box', 'al_project', 'normal', 'high' );
    add_meta_box( 'al_service_details', __( 'Service Details', 'allianzandco' ), 'al_service_meta_box', 'al_service', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'al_meta_boxes' );

function al_team_meta_box( $post ) {
    wp_nonce_field( 'al_save_meta', 'al_meta_nonce' );
    $role    = get_post_meta( $post->ID, '_al_role', true );
    $linked  = get_post_meta( $post->ID, '_al_linkedin', true );
    $twitter = get_post_meta( $post->ID, '_al_twitter', true );
    $email   = get_post_meta( $post->ID, '_al_email', true );
    ?>
    <p><label><strong><?php esc_html_e( 'Role / Position', 'allianzandco' ); ?></strong></label><br>
       <input type="text" name="_al_role" value="<?php echo esc_attr( $role ); ?>" style="width:100%"></p>
    <p><label><strong><?php esc_html_e( 'LinkedIn URL', 'allianzandco' ); ?></strong></label><br>
       <input type="url" name="_al_linkedin" value="<?php echo esc_attr( $linked ); ?>" style="width:100%"></p>
    <p><label><strong><?php esc_html_e( 'Twitter / X URL', 'allianzandco' ); ?></strong></label><br>
       <input type="url" name="_al_twitter" value="<?php echo esc_attr( $twitter ); ?>" style="width:100%"></p>
    <p><label><strong><?php esc_html_e( 'Email', 'allianzandco' ); ?></strong></label><br>
       <input type="email" name="_al_email" value="<?php echo esc_attr( $email ); ?>" style="width:100%"></p>
    <?php
}

function al_project_meta_box( $post ) {
    wp_nonce_field( 'al_save_meta', 'al_meta_nonce' );
    $client = get_post_meta( $post->ID, '_al_client', true );
    $loc    = get_post_meta( $post->ID, '_al_location', true );
    $year   = get_post_meta( $post->ID, '_al_year', true );
    ?>
    <p><label><strong><?php esc_html_e( 'Client', 'allianzandco' ); ?></strong></label><br>
       <input type="text" name="_al_client" value="<?php echo esc_attr( $client ); ?>" style="width:100%"></p>
    <p><label><strong><?php esc_html_e( 'Location', 'allianzandco' ); ?></strong></label><br>
       <input type="text" name="_al_location" value="<?php echo esc_attr( $loc ); ?>" style="width:100%"></p>
    <p><label><strong><?php esc_html_e( 'Year', 'allianzandco' ); ?></strong></label><br>
       <input type="text" name="_al_year" value="<?php echo esc_attr( $year ); ?>" style="width:100%"></p>
    <?php
}

function al_service_meta_box( $post ) {
    wp_nonce_field( 'al_save_meta', 'al_meta_nonce' );
    $icon  = get_post_meta( $post->ID, '_al_icon', true );
    $order = $post->menu_order;
    ?>
    <p><label><strong><?php esc_html_e( 'Icon name (font-awesome class, e.g. "fa-hard-hat")', 'allianzandco' ); ?></strong></label><br>
       <input type="text" name="_al_icon" value="<?php echo esc_attr( $icon ); ?>" style="width:100%"></p>
    <p class="description"><?php esc_html_e( 'Use a Font Awesome 5 class name. The icon is rendered automatically in the service card.', 'allianzandco' ); ?></p>
    <?php
}

function al_save_meta( $post_id ) {
    if ( ! isset( $_POST['al_meta_nonce'] ) || ! wp_verify_nonce( $_POST['al_meta_nonce'], 'al_save_meta' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    $fields = array( '_al_role', '_al_linkedin', '_al_twitter', '_al_email', '_al_client', '_al_location', '_al_year', '_al_icon' );
    foreach ( $fields as $f ) {
        if ( isset( $_POST[ $f ] ) ) {
            update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
        }
    }
}
add_action( 'save_post', 'al_save_meta' );

/* =========================================================================
 * 6. Customizer
 * ======================================================================= */
function al_customize_register( $wp_customize ) {
    // Hero
    $wp_customize->add_section( 'al_hero', array(
        'title'    => __( 'Homepage Hero', 'allianzandco' ),
        'priority' => 30,
    ) );
    $wp_customize->add_setting( 'al_hero_eyebrow', array( 'default' => 'Building Africa\'s Future', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'al_hero_eyebrow', array( 'label' => __( 'Eyebrow text', 'allianzandco' ), 'section' => 'al_hero' ) );
    $wp_customize->add_setting( 'al_hero_title', array( 'default' => 'Engineering excellence for the African continent', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'al_hero_title', array( 'label' => __( 'Hero title', 'allianzandco' ), 'section' => 'al_hero', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'al_hero_text', array( 'default' => 'We deliver complex projects with high technical, economic and social impact to power Africa\'s development.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'al_hero_text', array( 'label' => __( 'Hero description', 'allianzandco' ), 'section' => 'al_hero', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'al_hero_btn_label', array( 'default' => 'Discover our services', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'al_hero_btn_label', array( 'label' => __( 'Primary button label', 'allianzandco' ), 'section' => 'al_hero' ) );
    $wp_customize->add_setting( 'al_hero_btn_url', array( 'default' => home_url( '/services' ), 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'al_hero_btn_url', array( 'label' => __( 'Primary button URL', 'allianzandco' ), 'section' => 'al_hero' ) );
    $wp_customize->add_setting( 'al_hero_bg' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'al_hero_bg', array( 'label' => __( 'Hero background image', 'allianzandco' ), 'section' => 'al_hero' ) ) );

    // Stat counters
    $wp_customize->add_section( 'al_stats', array( 'title' => __( 'Homepage Stats', 'allianzandco' ), 'priority' => 31 ) );
    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( "al_stat_{$i}_num", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "al_stat_{$i}_num", array( 'label' => sprintf( __( 'Stat %d number', 'allianzandco' ), $i ), 'section' => 'al_stats' ) );
        $wp_customize->add_setting( "al_stat_{$i}_label", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "al_stat_{$i}_label", array( 'label' => sprintf( __( 'Stat %d label', 'allianzandco' ), $i ), 'section' => 'al_stats' ) );
    }

    // Contact
    $wp_customize->add_section( 'al_contact', array( 'title' => __( 'Contact Info', 'allianzandco' ), 'priority' => 32 ) );
    foreach ( array( 'address' => 'Address', 'phone' => 'Phone', 'email' => 'Email', 'hours' => 'Opening hours' ) as $k => $l ) {
        $wp_customize->add_setting( "al_contact_{$k}", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "al_contact_{$k}", array( 'label' => $l, 'section' => 'al_contact' ) );
    }
    $wp_customize->add_setting( 'al_contact_map' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'al_contact_map', array( 'label' => __( 'Contact image / map (optional)', 'allianzandco' ), 'section' => 'al_contact' ) ) );

    // Footer
    $wp_customize->add_section( 'al_footer', array( 'title' => __( 'Footer', 'allianzandco' ), 'priority' => 33 ) );
    $wp_customize->add_setting( 'al_footer_about', array( 'default' => 'ALLIANCE & CO delivers complex engineering and construction projects across the African continent with high technical, economic and social impact.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
    $wp_customize->add_control( 'al_footer_about', array( 'label' => __( 'Footer about text', 'allianzandco' ), 'section' => 'al_footer', 'type' => 'textarea' ) );
    foreach ( array( 'facebook' => 'Facebook URL', 'linkedin' => 'LinkedIn URL', 'twitter' => 'Twitter URL', 'instagram' => 'Instagram URL' ) as $k => $l ) {
        $wp_customize->add_setting( "al_social_{$k}", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( "al_social_{$k}", array( 'label' => $l, 'section' => 'al_footer' ) );
    }
}
add_action( 'customize_register', 'al_customize_register' );

/* =========================================================================
 * 7. Helpers
 * ======================================================================= */

/** Get customizer value with default. */
function al_opt( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}

/** Render a simple SVG icon (font-awesome free replacements). */
function al_icon( $name, $size = 24 ) {
    $icons = array(
        'helmet'    => '<path d="M12 2 2 7v3h20V7L12 2zm-7 9v3h14v-3H5zm-1 5v2h16v-2H4zm-1 4v2h18v-2H3z"/>',
        'building'  => '<path d="M3 21V8l9-5 9 5v13h-6v-7h-6v7H3z"/>',
        'bolt'      => '<path d="M13 2 3 14h7l-1 8 11-13h-8l1-7z"/>',
        'gear'      => '<path d="M19.14 12.94a7.06 7.06 0 0 0 0-1.88l2.03-1.58a.5.5 0 0 0 .12-.64l-1.92-3.32a.5.5 0 0 0-.61-.22l-2.39.96a7.03 7.03 0 0 0-1.62-.94l-.36-2.54A.5.5 0 0 0 13.9 2h-3.84a.5.5 0 0 0-.5.42l-.36 2.54c-.59.24-1.13.55-1.62.94l-2.39-.96a.5.5 0 0 0-.61.22L2.66 8.48a.5.5 0 0 0 .12.64l2.03 1.58a7.06 7.06 0 0 0 0 1.88L2.78 14.16a.5.5 0 0 0-.12.64l1.92 3.32c.14.24.43.34.69.24l2.39-.96c.49.39 1.03.7 1.62.94l.36 2.54c.04.24.25.42.5.42h3.84c.25 0 .46-.18.5-.42l.36-2.54c.59-.24 1.13-.55 1.62-.94l2.39.96c.26.1.55 0 .69-.24l1.92-3.32a.5.5 0 0 0-.12-.64l-2.03-1.58zM12 15.5A3.5 3.5 0 1 1 12 8.5a3.5 3.5 0 0 1 0 7z"/>',
        'leaf'      => '<path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z"/>',
        'shield'    => '<path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/>',
        'check'     => '<path d="M9 16.2 4.8 12l-1.4 1.4L9 19l12-12-1.4-1.4z"/>',
        'arrow'     => '<path d="M5 12h12.2l-4.6 4.6L14 18l7-7-7-7-1.4 1.4 4.6 4.6H5z"/>',
        'phone'     => '<path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A18 18 0 0 1 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.7.1.4 0 .7-.2 1l-2.3 2.1z"/>',
        'mail'      => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm0 4 8 5 8-5V6l-8 5-8-5v2z"/>',
        'pin'       => '<path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>',
        'clock'     => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm.5 5h-1v6l5.2 3.1.5-.9-4.7-2.7V7z"/>',
        'quote'     => '<path d="M7 7h4v4H8c0 2 1 3 3 3v2c-3 0-5-2-5-5V7zm9 0h4v4h-3c0 2 1 3 3 3v2c-3 0-5-2-5-5V7z"/>',
        'star'      => '<path d="m12 2 3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z"/>',
        'user'      => '<path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4 0-9 2-9 6v2h18v-2c0-4-5-6-9-6z"/>',
        'doc'       => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm0 7V3.5L19.5 9H14z"/>',
        'plus'      => '<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6z"/>',
    );
    $svg = isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['check'];
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="' . esc_attr( $size ) . '" height="' . esc_attr( $size ) . '" fill="currentColor" aria-hidden="true">' . $svg . '</svg>';
}

/** Excerpt with custom length. */
function al_excerpt( $length = 24 ) {
    $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_content() ) ), $length, '…' );
    return apply_filters( 'the_excerpt', $excerpt );
}

/** Estimate reading time. */
function al_reading_time( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field( 'post_content', $post_id );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    $mins    = max( 1, ceil( $words / 200 ) );
    return $mins;
}

/* =========================================================================
 * 8. Starter content (auto-populate on first activation)
 * ======================================================================= */
function al_starter_content() {
    $starter = array(
        'nav_menus' => array(
            'primary' => array(
                'name'  => __( 'Primary', 'allianzandco' ),
                'items' => array(
                    'link_home'       => array( 'type' => 'custom', 'title' => 'Home',     'url' => home_url( '/' ) ),
                    'page_about'      => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_about}}' ),
                    'page_services'   => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_services}}' ),
                    'page_team'       => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_team}}' ),
                    'page_history'    => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_history}}' ),
                    'page_faqs'       => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_faqs}}' ),
                    'page_blog'       => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_blog}}' ),
                    'page_contact'    => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_contact}}' ),
                ),
            ),
            'footer' => array(
                'name'  => __( 'Footer', 'allianzandco' ),
                'items' => array(
                    'link_home'      => array( 'type' => 'custom', 'title' => 'Home',     'url' => home_url( '/' ) ),
                    'page_about'     => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_about}}' ),
                    'page_services'  => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_services}}' ),
                    'page_contact'   => array( 'type' => 'post_type', 'object' => 'page', 'object_id' => '{{al_contact}}' ),
                ),
            ),
        ),
        'posts' => array(
            'al_about', 'al_services', 'al_team', 'al_history', 'al_philosophy',
            'al_faqs', 'al_blog', 'al_contact', 'al_404',
        ),
    );
    return $starter;
}
add_filter( 'get_theme_starter_content', '__return_false' ); // We handle seeding manually below.

/* =========================================================================
 * 9. On theme activation: seed content
 * ======================================================================= */
function al_seed_content() {
    // Only run once
    if ( get_option( 'al_seeded_v1' ) ) return;

    $theme_uri = AL_THEME_URI . '/assets/images';

    // 1. Create pages
    $pages = array(
        'al_about'      => array( 'title' => 'About Us',         'slug' => 'about-us',  'tpl' => 'page-about.php' ),
        'al_services'   => array( 'title' => 'Services',         'slug' => 'services',  'tpl' => 'page-services.php' ),
        'al_team'       => array( 'title' => 'Our Team',         'slug' => 'our-team',  'tpl' => 'page-team.php' ),
        'al_history'    => array( 'title' => 'Our History',      'slug' => 'history',   'tpl' => 'page-history.php' ),
        'al_philosophy' => array( 'title' => 'Our Philosophy',   'slug' => 'philosophy','tpl' => 'page-philosophy.php' ),
        'al_faqs'       => array( 'title' => 'FAQs',             'slug' => 'faqs',      'tpl' => 'page-faqs.php' ),
        'al_blog'       => array( 'title' => 'Blog',             'slug' => 'blog-list', 'tpl' => 'page-blog.php' ),
        'al_contact'    => array( 'title' => 'Contact',          'slug' => 'contacts',  'tpl' => 'page-contact.php' ),
    );

    $created = array();
    foreach ( $pages as $key => $p ) {
        $existing = get_page_by_path( $p['slug'] );
        if ( $existing ) {
            $created[ $key ] = $existing->ID;
            continue;
        }
        $pid = wp_insert_post( array(
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $p['title'],
            'post_name'    => $p['slug'],
            'post_content' => '',
        ) );
        if ( $pid && ! is_wp_error( $pid ) ) {
            update_post_meta( $pid, '_wp_page_template', $p['tpl'] );
            $created[ $key ] = $pid;
        }
    }

    // 2. Create home page (assigned to the homepage template)
    $home_page = get_page_by_path( 'home' );
    if ( ! $home_page ) {
        $home_page_id = wp_insert_post( array(
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => 'Home',
            'post_name'    => 'home',
            'post_content' => '',
        ) );
        if ( $home_page_id && ! is_wp_error( $home_page_id ) ) {
            update_post_meta( $home_page_id, '_wp_page_template', 'page-home.php' );
            $created['al_home'] = $home_page_id;
        }
    } else {
        $created['al_home'] = $home_page->ID;
    }

    // 3. Set front page
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $created['al_home'] );
    update_option( 'page_for_posts', $created['al_blog'] );

    // 4. Seed team
    $team_members = array(
        array( 'name' => 'Ostin Harrison',  'role' => 'Founder & CEO',          'img' => 'team-lead.jpg',     'excerpt' => 'Ostin founded Alliance & Co with a vision to deliver world-class engineering across the African continent.' ),
        array( 'name' => 'Amadou Diallo',   'role' => 'Chief Engineer',         'img' => 'about-1.jpg',       'excerpt' => 'A structural engineer with 20+ years of experience in large-scale infrastructure projects across West Africa.' ),
        array( 'name' => 'Sophie Laurent',  'role' => 'Head of Sustainability',  'img' => 'about-2.jpg',       'excerpt' => 'Sophie drives our commitment to sustainable construction and renewable energy integration.' ),
        array( 'name' => 'Karim Bensaïd',   'role' => 'Project Director',       'img' => 'project-1.jpg',     'excerpt' => 'Karim leads our high-voltage transmission and energy distribution projects.' ),
        array( 'name' => 'Ngozi Okafor',    'role' => 'Operations Manager',     'img' => 'project-2.jpg',     'excerpt' => 'Ngozi ensures the seamless execution of our multi-site construction operations.' ),
        array( 'name' => 'Daniel Mensah',   'role' => 'Lead Architect',         'img' => 'project-3.jpg',     'excerpt' => 'Daniel blends modern architectural vision with deep local context and craft.' ),
    );
    foreach ( $team_members as $i => $m ) {
        $existing = get_page_by_title( $m['name'], OBJECT, 'al_team' );
        if ( $existing ) { $team_ids[] = $existing->ID; continue; }
        $tid = wp_insert_post( array(
            'post_type'    => 'al_team',
            'post_status'  => 'publish',
            'post_title'   => $m['name'],
            'post_name'    => sanitize_title( $m['name'] ),
            'post_excerpt' => $m['excerpt'],
            'post_content' => '<p>' . $m['excerpt'] . '</p><p>With a deep commitment to engineering excellence and a passion for building Africa\'s future, ' . explode( ' ', $m['name'] )[0] . ' brings a wealth of expertise to every project.</p><p>The team member\'s professional journey includes working on major infrastructure, energy and construction projects across the continent — combining technical know-how with on-the-ground experience.</p>',
            'menu_order'   => $i,
        ) );
        if ( $tid && ! is_wp_error( $tid ) ) {
            update_post_meta( $tid, '_al_role', $m['role'] );
            $img_path = AL_THEME_DIR . '/assets/images/' . $m['img'];
            if ( file_exists( $img_path ) ) {
                $att_id = al_attach_image_from_path( $img_path, $m['name'] );
                if ( $att_id ) set_post_thumbnail( $tid, $att_id );
            }
        }
    }

    // 5. Seed FAQs
    $faqs = array(
        array( 'q' => 'What types of projects does Alliance & Co deliver?', 'a' => 'We deliver complex engineering, construction, energy and infrastructure projects across the African continent — including high-voltage transmission, solar and wind farms, industrial facilities and turnkey commercial builds.' ),
        array( 'q' => 'In which countries do you operate?',                  'a' => 'We are headquartered in France with active operations across West, East and North Africa, including Côte d\'Ivoire, Senegal, Nigeria, Ghana, Morocco, Kenya and Ethiopia.' ),
        array( 'q' => 'How do you ensure quality and safety on your sites?', 'a' => 'Every project is governed by an integrated quality, health, safety and environment (QHSE) system, certified to ISO 9001, ISO 14001 and ISO 45001 standards.' ),
        array( 'q' => 'Do you offer renewable energy solutions?',             'a' => 'Yes — solar PV plants, wind farms, hybrid energy systems and grid-stability solutions are core to our business. We design, finance and build.' ),
        array( 'q' => 'Can you support a project from feasibility to commissioning?', 'a' => 'Absolutely. Our full EPC / EPCM model covers feasibility, design, procurement, construction, commissioning and long-term operations & maintenance.' ),
        array( 'q' => 'How do I request a proposal?',                        'a' => 'Use the contact form on our website or email projects@alliance-co.net with your project brief, location and timeline. We will respond within two business days.' ),
    );
    foreach ( $faqs as $i => $f ) {
        $existing = get_page_by_title( $f['q'], OBJECT, 'al_faq' );
        if ( $existing ) continue;
        $fid = wp_insert_post( array(
            'post_type'    => 'al_faq',
            'post_status'  => 'publish',
            'post_title'   => $f['q'],
            'post_content' => $f['a'],
            'menu_order'   => $i,
        ) );
    }

    // 6. Seed Services
    $services = array(
        array( 't' => 'Engineering & Construction', 'd' => 'Turnkey EPC delivery of complex industrial, commercial and infrastructure projects, from feasibility to commissioning.' ),
        array( 't' => 'Energy & Power Grids',        'd' => 'High-voltage substations, transmission lines and distribution networks that connect cities and industries to reliable power.' ),
        array( 't' => 'Renewable Energy',            'd' => 'Utility-scale solar PV, wind farms and hybrid energy systems designed, financed and operated for long-term performance.' ),
        array( 't' => 'Civil & Structural Works',    'd' => 'Bridges, ports, roads, water systems and structural concrete delivered to international quality and safety standards.' ),
        array( 't' => 'Project Management',          'd' => 'Owner\'s engineering, EPCM and program management for multi-stakeholder infrastructure programs.' ),
        array( 't' => 'Operations & Maintenance',    'd' => 'Long-term O&M services for energy assets, industrial facilities and critical infrastructure — maximised uptime and lifecycle value.' ),
    );
    foreach ( $services as $i => $s ) {
        $existing = get_page_by_title( $s['t'], OBJECT, 'al_service' );
        if ( $existing ) continue;
        $sid = wp_insert_post( array(
            'post_type'    => 'al_service',
            'post_status'  => 'publish',
            'post_title'   => $s['t'],
            'post_content' => '<p>' . $s['d'] . '</p><p>Our multi-disciplinary team brings deep technical, regulatory and on-the-ground experience to every engagement. We align with international best-practice standards and partner with leading OEMs, financiers and engineering firms to deliver outcomes that last.</p>',
            'post_excerpt' => $s['d'],
            'menu_order'   => $i,
        ) );
    }

    // 7. Seed Projects
    $projects = array(
        array( 't' => 'Côte d\'Ivoire HV Substation',  'c' => 'CI-Energie', 'l' => 'Abidjan, Côte d\'Ivoire', 'y' => '2024', 'img' => 'project-1.jpg', 'cat' => 'Energy' ),
        array( 't' => 'Solar PV Plant — Touba',         'c' => 'Senelec',    'l' => 'Touba, Senegal',         'y' => '2024', 'img' => 'project-2.jpg', 'cat' => 'Renewable' ),
        array( 't' => 'Wind Farm — Lake Turkana',       'c' => 'LTWP',       'l' => 'Marsabit, Kenya',         'y' => '2023', 'img' => 'project-3.jpg', 'cat' => 'Renewable' ),
        array( 't' => 'Industrial Zone — Lagos',        'c' => 'LASEPA',     'l' => 'Lagos, Nigeria',          'y' => '2024', 'img' => 'hero-1.jpg',    'cat' => 'Construction' ),
        array( 't' => 'Port Expansion — Tema',          'c' => 'GPHA',       'l' => 'Tema, Ghana',             'y' => '2023', 'img' => 'about-1.jpg',   'cat' => 'Civil' ),
        array( 't' => 'Logistics Hub — Casablanca',     'c' => 'Marsa Maroc','l' => 'Casablanca, Morocco',     'y' => '2025', 'img' => 'about-2.jpg',   'cat' => 'Construction' ),
    );
    $cat_ids = array();
    foreach ( array_unique( wp_list_pluck( $projects, 'cat' ) ) as $c ) {
        $term = term_exists( $c, 'al_project_cat' );
        if ( ! $term ) $term = wp_insert_term( $c, 'al_project_cat' );
        $cat_ids[ $c ] = is_array( $term ) ? $term['term_id'] : $term;
    }
    foreach ( $projects as $i => $p ) {
        $existing = get_page_by_title( $p['t'], OBJECT, 'al_project' );
        if ( $existing ) continue;
        $pid = wp_insert_post( array(
            'post_type'    => 'al_project',
            'post_status'  => 'publish',
            'post_title'   => $p['t'],
            'post_content' => '<p>A flagship project for ' . esc_html( $p['c'] ) . ', delivered to the highest international standards of quality, safety and environmental performance.</p>',
            'post_excerpt' => 'A flagship project delivered for ' . $p['c'] . ' in ' . $p['l'] . '.',
            'menu_order'   => $i,
        ) );
        if ( $pid && ! is_wp_error( $pid ) ) {
            update_post_meta( $pid, '_al_client',   $p['c'] );
            update_post_meta( $pid, '_al_location', $p['l'] );
            update_post_meta( $pid, '_al_year',     $p['y'] );
            wp_set_object_terms( $pid, $cat_ids[ $p['cat'] ], 'al_project_cat' );
            $img_path = AL_THEME_DIR . '/assets/images/' . $p['img'];
            if ( file_exists( $img_path ) ) {
                $att_id = al_attach_image_from_path( $img_path, $p['t'] );
                if ( $att_id ) set_post_thumbnail( $pid, $att_id );
            }
        }
    }

    // 8. Seed blog posts
    $posts = array(
        array( 't' => 'Custom vs Prefab Homes: which is right for Africa?', 'img' => 'blog-1.jpeg', 'excerpt' => 'As Africa\'s urban population doubles by 2050, the choice between custom-built and prefabricated housing has never been more important. We compare both approaches.' ),
        array( 't' => 'Building Smarter Homes with Modular Construction',   'img' => 'blog-2.jpeg', 'excerpt' => 'Modular construction is transforming how we deliver homes — faster, greener, and with higher quality. Here\'s how we are deploying it across the continent.' ),
        array( 't' => 'Building with Passion and Purpose',                  'img' => 'blog-3.jpeg', 'excerpt' => 'Behind every Alliance & Co project is a team of passionate engineers, builders and operators. Meet the people powering Africa\'s infrastructure.' ),
        array( 't' => 'Sustainable Construction Wins in the Long Run',      'img' => 'blog-4.jpg',  'excerpt' => 'Sustainability is no longer a "nice to have". We share the data behind why green construction outperforms traditional builds across the lifecycle.' ),
        array( 't' => 'The Rise of Sustainable Building in West Africa',    'img' => 'blog-5.jpeg', 'excerpt' => 'From Lagos to Dakar, sustainable building practices are taking root. We explore the policy, capital and talent trends driving the shift.' ),
        array( 't' => 'Trends Shaping the Construction Industry in 2025',  'img' => 'project-1.jpg','excerpt' => 'AI, modular construction, ESG-linked finance and local content rules — the trends every African construction leader should track in 2025.' ),
    );
    foreach ( $posts as $i => $p ) {
        $existing = get_page_by_title( $p['t'], OBJECT, 'post' );
        if ( $existing ) continue;
        $bid = wp_insert_post( array(
            'post_type'    => 'post',
            'post_status'  => 'publish',
            'post_title'   => $p['t'],
            'post_name'    => sanitize_title( $p['t'] ),
            'post_excerpt' => $p['excerpt'],
            'post_content' => '<p>' . $p['excerpt'] . '</p><p>This article explores the topic in depth, drawing on the experience of the Alliance & Co team across major projects in West, East and North Africa. We share real data, case studies and lessons learned — from feasibility to commissioning.</p><h2>Why this matters</h2><p>Africa\'s infrastructure gap is well documented, but the path to closing it is less discussed. We believe that pragmatic engineering, combined with deep local context, is the only way to deliver projects that last.</p><h2>How Alliance & Co approaches it</h2><p>Our integrated delivery model brings together design, procurement, construction, operations and financing under one roof — reducing interfaces, accelerating timelines and derisking outcomes for our clients.</p><blockquote>"Africa does not need more pilots. It needs more projects that get built, perform and last." — Ostin Harrison, CEO</blockquote><p>Whether you are a public utility, a private developer or a development finance institution, we would be glad to discuss how we can support your next project. Reach out via our contact page.</p>',
            'post_date'    => date( 'Y-m-d H:i:s', strtotime( "-{$i} days" ) ),
        ) );
        if ( $bid && ! is_wp_error( $bid ) ) {
            $img_path = AL_THEME_DIR . '/assets/images/' . $p['img'];
            if ( file_exists( $img_path ) ) {
                $att_id = al_attach_image_from_path( $img_path, $p['t'] );
                if ( $att_id ) set_post_thumbnail( $bid, $att_id );
            }
        }
    }

    // 9. Default customizer values
    if ( ! get_theme_mod( 'al_hero_title' ) ) {
        set_theme_mod( 'al_hero_title', 'Engineering excellence for the African continent' );
        set_theme_mod( 'al_hero_text',  'We deliver complex projects with high technical, economic and social impact to power Africa\'s development.' );
        set_theme_mod( 'al_hero_eyebrow', 'Building Africa\'s Future' );
        set_theme_mod( 'al_stat_1_num', '120+' );
        set_theme_mod( 'al_stat_1_label', 'Projects delivered' );
        set_theme_mod( 'al_stat_2_num', '18' );
        set_theme_mod( 'al_stat_2_label', 'Countries served' );
        set_theme_mod( 'al_stat_3_num', '350' );
        set_theme_mod( 'al_stat_3_label', 'Engineers & builders' );
        set_theme_mod( 'al_stat_4_num', '98%' );
        set_theme_mod( 'al_stat_4_label', 'Client satisfaction' );
        set_theme_mod( 'al_contact_address', '15 rue de l\'Innovation, 75008 Paris, France' );
        set_theme_mod( 'al_contact_phone', '+33 1 84 88 56 12' );
        set_theme_mod( 'al_contact_email', 'contact@alliance-co.net' );
        set_theme_mod( 'al_contact_hours', 'Mon – Fri: 8.00 – 18.00 (GMT+1)' );
        set_theme_mod( 'al_footer_about', 'ALLIANCE & CO delivers complex engineering and construction projects across the African continent with high technical, economic and social impact.' );
        set_theme_mod( 'al_social_linkedin', 'https://www.linkedin.com/' );
        set_theme_mod( 'al_social_twitter',  'https://twitter.com/' );
        set_theme_mod( 'al_social_facebook', 'https://facebook.com/' );
    }

    // Set pretty permalinks on first run.
    if ( ! get_option( 'al_permalinks_set' ) ) {
        global $wp_rewrite;
        update_option( 'permalink_structure', '/%postname%/' );
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
        update_option( 'al_permalinks_set', 1 );
    }

    // Configure TranslatePress for FR/EN (only if plugin is active)
    al_setup_translatepress();

    // Flush rewrite rules so the new CPT/Tax permalinks work immediately.
    flush_rewrite_rules();

    update_option( 'al_seeded_v1', 1 );
}
add_action( 'after_switch_theme', 'al_seed_content' );

/* Attach an image from theme directory to the media library and return its ID. */
function al_attach_image_from_path( $path, $title = '' ) {
    if ( ! file_exists( $path ) ) return 0;
    $upload = wp_upload_dir();
    $filename = basename( $path );
    $target   = $upload['path'] . '/' . wp_unique_filename( $upload['path'], $filename );
    if ( ! @copy( $path, $target ) ) return 0;
    $wp_filetype = wp_check_filetype( $filename );
    $attachment = array(
        'guid'           => $upload['url'] . '/' . basename( $target ),
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => $title ?: preg_replace( '/\.[^.]+$/', '', $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit',
    );
    $att_id = wp_insert_attachment( $attachment, $target );
    if ( ! is_wp_error( $att_id ) ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata( $att_id, $target );
        wp_update_attachment_metadata( $att_id, $attach_data );
        return $att_id;
    }
    return 0;
}

/* =========================================================================
 * 10. Widgets
 * ======================================================================= */
function al_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'allianzandco' ),
        'id'            => 'sidebar-blog',
        'before_widget' => '<div id="%1$s" class="al-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="al-widget__title">',
        'after_title'   => '</h4>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer', 'allianzandco' ),
        'id'            => 'sidebar-footer',
        'before_widget' => '<div id="%1$s" class="al-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'al_widgets_init' );

/* =========================================================================
 * 11. Comments list (Bootstrap-ish minimal)
 * ======================================================================= */
function al_comment_callback( $comment, $args, $depth ) {
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article class="al-comment">
            <header class="al-comment__head">
                <?php echo get_avatar( $comment, 48 ); ?>
                <div>
                    <h5 class="al-comment__author"><?php comment_author(); ?></h5>
                    <time class="al-comment__date" datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'allianzandco' ), get_comment_date(), get_comment_time() ); ?></time>
                </div>
            </header>
            <div class="al-comment__body"><?php comment_text(); ?></div>
            <footer><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></footer>
        </article>
    <?php
}

/* =========================================================================
 * 12. Performance & misc
 * ======================================================================= */
// Remove emoji scripts (not needed for corporate site)
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Async/defer theme JS
function al_defer_scripts( $tag, $handle ) {
    if ( 'al-main' === $handle ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'al_defer_scripts', 10, 2 );

/* =========================================================================
 * 13. Bilingual FR/EN — TranslatePress + theme string translations
 * ======================================================================= */

/**
 * Configure TranslatePress on first activation.
 * Sets default language to English, adds French as a translation language,
 * enables the free Google Translate machine translator.
 */
function al_setup_translatepress() {
    if ( ! function_exists( 'trp_enable_translation_editor_on_page' ) ) {
        return; // TranslatePress not active
    }
    // Default settings (these mirror what the user would set in Settings → TranslatePress)
    $defaults = array(
        'default-language'                   => 'en_US',
        'translation-languages'              => array( 'fr_FR' ),
        'publish-languages'                  => 'fr_FR',
        'native-or-english-language'         => 'en_US',
        'translation-memory'                 => array(),
        'url-slugs'                          => array( 'en_US' => '', 'fr_FR' => 'fr' ),
        'show-slug'                          => 'yes',
        'google-translate-caching'           => 'yes',
        'google-translate-translation-time'  => 5,
        'deepl-translation-time'             => 5,
        'translation-engine'                 => 'translation-memory',
        'machine-translation-enabled'        => 'yes',
        'machine-translation-engine'         => 'google_translate',
    );
    $existing = get_option( 'translatepress_settings', array() );
    $merged   = array_merge( $existing, $defaults );
    // Convert translation-languages to the format TP expects
    if ( isset( $merged['translation-languages'] ) && is_array( $merged['translation-languages'] ) ) {
        $merged['translation-languages'] = array_combine( $merged['translation-languages'], $merged['translation-languages'] );
    }
    update_option( 'translatepress_settings', $merged );
    update_option( 'trp_language', 'en_US' );
    update_option( 'trp_licence_key', '' );
}

/**
 * Gettext filter — translates common theme strings to French immediately
 * (independent of TranslatePress, so FR users see translated UI right away).
 */
function al_theme_gettext( $translation, $text, $domain ) {
    if ( $domain !== 'allianzandco' ) return $translation;
    if ( get_locale() === 'fr_FR' || strpos( get_locale(), 'fr' ) === 0 ) {
        $dict = al_fr_string_dictionary();
        if ( isset( $dict[ $text ] ) ) return $dict[ $text ];
    }
    return $translation;
}
add_filter( 'gettext', 'al_theme_gettext', 20, 3 );

/**
 * French translations of common theme strings.
 * TranslatePress will translate the rest (post content, custom strings) on demand.
 */
function al_fr_string_dictionary() {
    return array(
        // Header / nav
        'Home'                             => 'Accueil',
        'Get in touch'                     => 'Nous contacter',
        'Toggle menu'                      => 'Ouvrir le menu',
        'About'                            => 'À propos',
        'Services'                         => 'Services',
        'Team'                             => 'Équipe',
        'Philosophy'                       => 'Philosophie',
        'History'                          => 'Histoire',
        'FAQs'                             => 'FAQ',
        'Blog'                             => 'Blog',
        'Contact'                          => 'Contact',
        'Skip to content'                  => 'Aller au contenu',
        // Buttons
        'Learn more'                       => 'En savoir plus',
        'Read article'                     => 'Lire l\u2019article',
        'View all services'                => 'Voir tous les services',
        'More about us'                    => 'En savoir plus sur nous',
        'Meet the full team'               => 'Toute l\u2019\u00e9quipe',
        'Back to home'                     => 'Retour \u00e0 l\u2019accueil',
        'Contact us'                       => 'Nous contacter',
        'Back to the team'                 => 'Retour \u00e0 l\u2019\u00e9quipe',
        'Send message'                     => 'Envoyer le message',
        'All articles'                     => 'Tous les articles',
        'Explore our work'                 => 'Explorer nos projets',
        'Our services'                     => 'Nos services',
        'Join the team'                    => 'Rejoindre l\u2019\u00e9quipe',
        'Still have questions?'            => 'D\u2019autres questions\u202f?',
        // Sections
        'What we do'                       => 'Ce que nous faisons',
        'End-to-end engineering, energy & construction' => 'Ing\u00e9nierie, \u00e9nergie et construction cl\u00e9 en main',
        'From feasibility to commissioning, we deliver complex projects that power Africa\'s growth — combining deep technical expertise with on-the-ground execution.' => 'De l\u2019\u00e9tude de faisabilit\u00e9 \u00e0 la mise en service, nous livrons des projets complexes qui propulsent la croissance de l\u2019Afrique — en combinant expertise technique pointue et ex\u00e9cution terrain.',
        'Who we are'                       => 'Qui nous sommes',
        'Our team'                         => 'Notre \u00e9quipe',
        'Our values'                       => 'Nos valeurs',
        'What guides every project we deliver' => 'Ce qui guide chacun de nos projets',
        'Our philosophy'                   => 'Notre philosophie',
        'A word from the CEO'              => 'Le mot du PDG',
        'Selected projects'                => 'Projets s\u00e9lectionn\u00e9s',
        'Built across the continent'       => 'B\u00e2ti \u00e0 travers le continent',
        'Trusted by'                       => 'Ils nous font confiance',
        'Public utilities, private developers & financial partners' => 'Services publics, promoteurs priv\u00e9s et partenaires financiers',
        'From the field'                   => 'Sur le terrain',
        'Insights'                         => 'Analyses',
        'How we deliver'                   => 'Notre approche',
        'An integrated delivery model'     => 'Un mod\u00e8le de livraison int\u00e9gr\u00e9',
        'Get in touch'                     => 'Entrons en contact',
        // Stats
        'Projects delivered across Africa' => 'Projets livr\u00e9s en Afrique',
        'Countries with active operations' => 'Pays d\u2019op\u00e9rations actives',
        'Engineers, builders and operators'=> 'Ing\u00e9nieurs, constructeurs et op\u00e9rateurs',
        'Client satisfaction rate'         => 'Taux de satisfaction client',
        // Misc
        'Engineering excellence for the African continent' => 'L\u2019excellence de l\u2019ing\u00e9nierie au service du continent africain',
        'Building Africa\'s Future'         => 'B\u00e2tir l\u2019avenir de l\u2019Afrique',
        'Scroll'                           => 'D\u00e9filer',
        'Breadcrumb'                       => 'Fil d\u2019Ariane',
        'Previous'                         => 'Pr\u00e9c\u00e9dent',
        'Next'                             => 'Suivant',
        'Read our philosophy'              => 'Lire notre philosophie',
        'See how we put this into practice'=> 'D\u00e9couvrez comment nous l\u2019appliquons',
        'Ready to discuss your next project?' => 'Pr\u00eat \u00e0 discuter de votre prochain projet\u202f?',
        'Want to work with us?'            => 'Vous souhaitez travailler avec nous\u202f?',
        'Be part of the next chapter'      => 'Faites partie du prochain chapitre',
        'Tell us about your project'       => 'Parlez-nous de votre projet',
        '20+ years of engineering Africa\'s most ambitious projects' => 'Plus de 20 ans d\u2019ing\u00e9nierie des projets les plus ambitieux d\u2019Afrique',
        'A multi-disciplinary engineering company with a continental footprint' => 'Une soci\u00e9t\u00e9 d\u2019ing\u00e9nierie pluridisciplinaire \u00e0 l\u2019\u00e9chelle du continent',
        'About Alliance & Co'              => '\u00c0 propos d\u2019Alliance & Co',
        'A continent-wide team of engineers, builders and operators who care deeply about the projects they deliver.' => 'Une \u00e9quipe continentale d\u2019ing\u00e9nieurs, constructeurs et op\u00e9rateurs qui croient profond\u00e9ment aux projets qu\u2019ils livrent.',
        'The people behind every project'  => 'Les femmes et les hommes derri\u00e8re chaque projet',
        'Built on trust, designed to last' => 'B\u00e2ti sur la confiance, con\u00e7u pour durer',
        'We believe infrastructure is more than concrete and steel — it is the foundation of opportunity.' => 'Nous sommes convaincus que les infrastructures sont plus que du b\u00e9ton et de l\u2019acier\u202f: elles sont le socle des opportunit\u00e9s.',
        'Building Africa\'s future, one project at a time' => 'B\u00e2tir l\u2019avenir de l\u2019Afrique, un projet \u00e0 la fois',
        'From a small engineering practice to a continent-wide EPC partner — twenty years of building Africa.' => 'D\u2019un petit cabinet d\u2019ing\u00e9nierie \u00e0 un partenaire EPC \u00e0 l\u2019\u00e9chelle du continent — vingt ans \u00e0 b\u00e2tir l\u2019Afrique.',
        'Six core capabilities, delivered as one integrated EPC and O&M partner.' => 'Six m\u00e9tiers compl\u00e9mentaires, livr\u00e9s par un partenaire EPC et O&M int\u00e9gr\u00e9.',
        'Answers to the questions we get most often from clients, partners and candidates.' => 'Les r\u00e9ponses aux questions que nos clients, partenaires et candidats nous posent le plus souvent.',
        'Tell us about your project — we will respond within two business days.' => 'Parlez-nous de votre projet — nous r\u00e9pondrons sous deux jours ouvr\u00e9s.',
        'Insights, case studies and field reports from the Alliance & Co team.' => 'Analyses, \u00e9tudes de cas et retours d\u2019exp\u00e9rience de l\u2019\u00e9quipe Alliance & Co.',
        'Page not found'                   => 'Page introuvable',
        'The page you are looking for might have been moved, deleted, or perhaps never existed. Try one of the links below.' => 'La page que vous cherchez a peut-\u00eatre \u00e9t\u00e9 d\u00e9plac\u00e9e, supprim\u00e9e ou n\u2019a jamais exist\u00e9. Essayez l\u2019un des liens ci-dessous.',
        'No posts found.'                  => 'Aucun article trouv\u00e9.',
        'No team members found.'           => 'Aucun membre de l\u2019\u00e9quipe trouv\u00e9.',
        'Comments'                         => 'Commentaires',
        '1 comment'                        => '1 commentaire',
        '%s comments'                      => '%s commentaires',
        'Add a comment'                    => 'Ajouter un commentaire',
        'Leave a comment'                  => 'Laisser un commentaire',
        'Name *'                           => 'Nom *',
        'Email *'                          => 'E-mail *',
        'Phone'                            => 'T\u00e9l\u00e9phone',
        'Subject'                          => 'Sujet',
        'Message *'                        => 'Message *',
        'Address'                          => 'Adresse',
        'Opening hours'                    => 'Horaires d\u2019ouverture',
        'New contact from %s'              => 'Nouveau contact de %s',
        'There was a problem sending your message. Please try again or email us directly.' => 'Un probl\u00e8me est survenu lors de l\u2019envoi de votre message. Veuillez r\u00e9essayer ou nous \u00e9crire directement.',
        'Please fill in all required fields with valid information.' => 'Veuillez remplir tous les champs obligatoires avec des informations valides.',
        'Thank you!'                       => 'Merci\u202f!',
        'Your message has been sent. We will get back to you within two business days.' => 'Votre message a bien \u00e9t\u00e9 envoy\u00e9. Nous vous r\u00e9pondrons sous deux jours ouvr\u00e9s.',
        'Fill in the form below and we will get back to you shortly.' => 'Remplissez le formulaire ci-dessous et nous reviendrons vers vous rapidement.',
        'Send us a message'                => 'Envoyez-nous un message',
        // Process
        'Feasibility'                      => 'Faisabilit\u00e9',
        'Engineering'                      => 'Ing\u00e9nierie',
        'Construction'                     => 'Construction',
        'Operate'                          => 'Exploitation',
        'We work with clients to scope, model and de-risk the project from day one.' => 'Nous accompagnons nos clients pour cadrer, mod\u00e9liser et d\u00e9risquer le projet d\u00e8s le premier jour.',
        'Our multi-disciplinary engineering teams design to international codes and local context.' => 'Nos \u00e9quipes d\u2019ing\u00e9nierie pluridisciplinaires con\u00e7oivent selon les codes internationaux et le contexte local.',
        'We self-perform the critical path and orchestrate the rest with trusted local partners.' => 'Nous r\u00e9alisons nous-m\u00eames le chemin critique et coordonnons le reste avec des partenaires locaux de confiance.',
        'We stay involved — operating, maintaining and optimising the asset for the long term.' => 'Nous restons impliqu\u00e9s — exploitation, maintenance et optimisation de l\u2019ouvrage sur le long terme.',
        // Values
        'Safety first'                     => 'S\u00e9curit\u00e9 d\u2019abord',
        'No project is successful if our people or communities are not safe. QHSE is built into every plan, every site, every shift.' => 'Aucun projet n\u2019est un succ\u00e8s si nos collaborateurs ou nos communaut\u00e9s ne sont pas en s\u00e9curit\u00e9. Le QHSE est int\u00e9gr\u00e9 \u00e0 chaque plan, chaque site, chaque poste.',
        'Engineering excellence'          => 'Excellence ing\u00e9nierie',
        'We design and build to international standards, with discipline, rigour and a long-term view of performance.' => 'Nous concevons et construisons selon les standards internationaux, avec discipline, rigueur et une vision long terme de la performance.',
        'Local content'                    => 'Contenu local',
        'We invest in local teams, suppliers and partners — creating lasting capability wherever we operate.' => 'Nous investissons dans les \u00e9quipes, fournisseurs et partenaires locaux — pour cr\u00e9er une capacit\u00e9 durable partout o\u00f9 nous intervenons.',
        'Operational discipline'           => 'Discipline op\u00e9rationnelle',
        'We plan, track and adapt in real time. Our project controls are designed to give clients clarity and confidence.' => 'Nous planifions, suivons et nous adaptons en temps r\u00e9el. Nos outils de pilotage offrent clart\u00e9 et confiance \u00e0 nos clients.',
        'Long-term partnership'            => 'Partenariat de long terme',
        'Most of our work comes from repeat clients. We earn trust by delivering — and we keep delivering long after handover.' => 'La majorit\u00e9 de nos activit\u00e9s vient de clients fid\u00e8les. Nous m\u00e9ritons la confiance en livrant — et continuons bien apr\u00e8s la r\u00e9ception.',
        'Africa does not need more pilots. It needs more projects that get built, perform and last.' => 'L\u2019Afrique n\u2019a pas besoin de plus de pilotes. Elle a besoin de plus de projets qui se construisent, fonctionnent et durent.',
        'Founder & CEO'                    => 'Fondateur & PDG',
        'Founder & CEO, Alliance & Co'     => 'Fondateur & PDG, Alliance & Co',
        '© %s %s. All rights reserved.'    => '© %s %s. Tous droits r\u00e9serv\u00e9s.',
        'Explore'                          => 'Explorer',
        'Services'                         => 'Services',
        'Contact'                          => 'Contact',
    );
}

/**
 * TranslatePress support: hide the default language prefix in URLs.
 */
add_filter( 'trp_skip_selectors_from_translation', function( $skip ) {
    // Skip WP admin bar and other dynamic content
    $skip[] = '#wpadminbar';
    $skip[] = '.al-cookie-notice';
    return $skip;
}, 10, 1 );
