<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/bbau-logo-900x460.png'); ?>" alt="<?php bloginfo('name'); ?>">
        </a>

        <button class="menu-toggle" id="menu-toggle" aria-label="Menü öffnen" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-nav" id="main-nav" role="navigation" aria-label="Hauptnavigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '<ul>%3$s</ul>',
                'walker'         => new Bernstorf_Nav_Walker(),
                'fallback_cb'    => 'bernstorf_fallback_menu',
            ));
            ?>
        </nav>
    </div>
</header>

<?php
function bernstorf_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Startseite</a></li>';
    wp_list_pages(array(
        'title_li' => '',
        'depth'    => 1,
    ));
    echo '</ul>';
}
?>
