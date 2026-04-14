<?php
/**
 * Bernstorf Bau Theme Functions
 */

define('BERNSTORF_VERSION', '1.8.0');

/**
 * Theme Setup
 */
function bernstorf_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => 'Hauptnavigation',
        'footer'  => 'Footer Navigation',
    ));

    add_image_size('hero-slide', 1920, 800, true);
    add_image_size('project-thumb', 600, 400, true);
    add_image_size('service-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'bernstorf_setup');

/**
 * Enqueue Scripts & Styles
 */
function bernstorf_scripts() {
    wp_enqueue_style('bernstorf-style', get_stylesheet_uri(), array(), BERNSTORF_VERSION);
    wp_enqueue_script('bernstorf-main', get_template_directory_uri() . '/assets/js/main.js', array(), BERNSTORF_VERSION, true);

    if (is_page_template('page-kontakt.php') || is_page('kontakt')) {
        wp_localize_script('bernstorf-main', 'bernstorf_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('bernstorf_contact_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'bernstorf_scripts');

/**
 * Custom Menu Walker for clean markup
 */
class Bernstorf_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array(
            'title'  => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel'    => !empty($item->xfn) ? $item->xfn : '',
            'href'   => !empty($item->url) ? $item->url : '',
        );

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $output .= '<a' . $attributes . '>' . esc_html(apply_filters('the_title', $item->title, $item->ID)) . '</a>';
    }
}

/**
 * Hero Slides Custom Post Type
 */
function bernstorf_register_hero_slides() {
    register_post_type('hero_slide', array(
        'labels' => array(
            'name'          => 'Hero Slides',
            'singular_name' => 'Hero Slide',
            'add_new'       => 'Neuer Slide',
            'add_new_item'  => 'Neuen Slide hinzufügen',
            'edit_item'     => 'Slide bearbeiten',
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => array('title', 'thumbnail'),
        'menu_icon'    => 'dashicons-images-alt2',
        'menu_position'=> 20,
    ));
}
add_action('init', 'bernstorf_register_hero_slides');

/**
 * Hero Slide Meta Box for subtitle
 */
function bernstorf_hero_meta_boxes() {
    add_meta_box('hero_subtitle', 'Slide Untertitel', 'bernstorf_hero_subtitle_callback', 'hero_slide', 'normal', 'high');
}
add_action('add_meta_boxes', 'bernstorf_hero_meta_boxes');

function bernstorf_hero_subtitle_callback($post) {
    wp_nonce_field('bernstorf_hero_subtitle', 'bernstorf_hero_subtitle_nonce');
    $subtitle = get_post_meta($post->ID, '_hero_subtitle', true);
    echo '<textarea name="hero_subtitle" style="width:100%;height:80px;">' . esc_textarea($subtitle) . '</textarea>';
}

function bernstorf_save_hero_subtitle($post_id) {
    if (!isset($_POST['bernstorf_hero_subtitle_nonce']) || !wp_verify_nonce($_POST['bernstorf_hero_subtitle_nonce'], 'bernstorf_hero_subtitle')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['hero_subtitle'])) {
        update_post_meta($post_id, '_hero_subtitle', sanitize_textarea_field($_POST['hero_subtitle']));
    }
}
add_action('save_post_hero_slide', 'bernstorf_save_hero_subtitle');

/**
 * Projekte Custom Post Type
 */
function bernstorf_register_projekte() {
    register_post_type('projekt', array(
        'labels' => array(
            'name'          => 'Projekte',
            'singular_name' => 'Projekt',
            'add_new'       => 'Neues Projekt',
            'add_new_item'  => 'Neues Projekt hinzufügen',
            'edit_item'     => 'Projekt bearbeiten',
        ),
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'projekte'),
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon'    => 'dashicons-building',
        'menu_position'=> 21,
        'show_in_rest' => true,
    ));

    register_taxonomy('projekt_kategorie', 'projekt', array(
        'labels' => array(
            'name'          => 'Projekt-Kategorien',
            'singular_name' => 'Kategorie',
        ),
        'public'       => true,
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'projekt-kategorie'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'bernstorf_register_projekte');

/**
 * Contact Form Handler
 */
require_once get_template_directory() . '/inc/contact-form.php';

/**
 * Theme Setup Wizard (erstellt Seiten, Menüs, Einstellungen)
 */
require_once get_template_directory() . '/inc/theme-setup-wizard.php';

/**
 * Bilder-Importer (einmalig)
 */
require_once get_template_directory() . '/inc/import-projekte.php';

/**
 * Projekte-Archiv: 12 pro Seite
 */
function bernstorf_projekte_per_page($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('projekt')) {
        $query->set('posts_per_page', 12);
    }
}
add_action('pre_get_posts', 'bernstorf_projekte_per_page');

/**
 * Theme Customizer
 */
function bernstorf_customizer($wp_customize) {
    // Contact Info Section
    $wp_customize->add_section('bernstorf_contact', array(
        'title'    => 'Kontaktdaten',
        'priority' => 30,
    ));

    $fields = array(
        'owner'   => array('label' => 'Inhaber / Ansprechpartner', 'default' => 'Christian Bernstorf'),
        'phone'   => array('label' => 'Telefon', 'default' => ''),
        'email'   => array('label' => 'E-Mail', 'default' => ''),
        'address' => array('label' => 'Adresse', 'default' => ''),
        'city'    => array('label' => 'PLZ / Ort', 'default' => ''),
    );

    foreach ($fields as $key => $field) {
        $wp_customize->add_setting("bernstorf_{$key}", array(
            'default'           => $field['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("bernstorf_{$key}", array(
            'label'   => $field['label'],
            'section' => 'bernstorf_contact',
            'type'    => 'text',
        ));
    }

    // Social Media
    $wp_customize->add_section('bernstorf_social', array(
        'title'    => 'Social Media',
        'priority' => 35,
    ));

    $socials = array('facebook', 'instagram');
    foreach ($socials as $social) {
        $wp_customize->add_setting("bernstorf_{$social}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("bernstorf_{$social}", array(
            'label'   => ucfirst($social) . ' URL',
            'section' => 'bernstorf_social',
            'type'    => 'url',
        ));
    }
}
add_action('customize_register', 'bernstorf_customizer');

/**
 * Helper: Bilder fuer Slider aus Projekten einer Kategorie sammeln
 *
 * @param array|string $category_slugs Slug(s) der projekt_kategorie
 * @param int $limit Maximale Anzahl Bilder
 * @return array Liste von ['src' => url, 'alt' => title]
 */
function bernstorf_slider_images($category_slugs = array(), $limit = 10) {
    $args = array(
        'post_type'      => 'projekt',
        'posts_per_page' => 20,
        'orderby'        => 'rand',
    );

    if (!empty($category_slugs)) {
        $args['tax_query'] = array(array(
            'taxonomy' => 'projekt_kategorie',
            'field'    => 'slug',
            'terms'    => (array) $category_slugs,
        ));
    }

    $projects = get_posts($args);

    $images = array();
    $seen = array();

    foreach ($projects as $project) {
        // Featured Image zuerst
        $thumb_id = get_post_thumbnail_id($project->ID);
        if ($thumb_id && !isset($seen[$thumb_id])) {
            $images[] = array(
                'src'   => wp_get_attachment_image_url($thumb_id, 'large'),
                'alt'   => get_the_title($project),
                'title' => get_the_title($project),
            );
            $seen[$thumb_id] = true;
        }

        // Plus alle anderen Bilder des Projekts
        $attachments = get_posts(array(
            'post_type'      => 'attachment',
            'post_parent'    => $project->ID,
            'posts_per_page' => -1,
            'post_mime_type' => 'image',
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ));

        foreach ($attachments as $att) {
            if (isset($seen[$att->ID])) {
                continue;
            }
            $images[] = array(
                'src'   => wp_get_attachment_image_url($att->ID, 'large'),
                'alt'   => $att->post_title,
                'title' => get_the_title($project),
            );
            $seen[$att->ID] = true;
            if (count($images) >= $limit) {
                break 2;
            }
        }
    }

    return array_slice($images, 0, $limit);
}

/**
 * Helper: Get theme SVG icon
 */
function bernstorf_icon($name) {
    $icons = array(
        'trowel' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7z"/></svg>',
        'wall' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M3 5v14h18V5H3zm4 12H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V7h2v2zm6 8H9v-2h4v2zm0-4H9v-2h4v2zm0-4H9V7h4v2zm6 8h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4V7h4v2z"/></svg>',
        'house' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>',
        'repair' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/></svg>',
        'building' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15 11V5l-3-3-3 3v2H3v14h18V11h-6zm-8 8H5v-2h2v2zm0-4H5v-2h2v2zm0-4H5V9h2v2zm6 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm6 12h-2v-2h2v2zm0-4h-2v-2h2v2z"/></svg>',
        'shield' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'phone' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>',
        'mail' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
        'location' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
    );

    return isset($icons[$name]) ? $icons[$name] : '';
}
