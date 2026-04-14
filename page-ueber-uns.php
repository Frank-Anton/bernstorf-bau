<?php
/**
 * Template Name: Über uns
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <div class="page-header__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Startseite</a> &raquo; <span><?php the_title(); ?></span>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="ueber-uns__hero-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>

        <!-- Slider mit Eindruecken aus allen Projekten -->
        <div class="ueber-uns__slider-section">
            <h2 class="ueber-uns__slider-title">Eindr&uuml;cke unserer Arbeit</h2>
            <p class="ueber-uns__slider-subtitle">Ein Querschnitt durch unsere Projekte &ndash; vom Neubau bis zur Sanierung.</p>
            <?php
            $slider_images = bernstorf_slider_images(array(), 12);
            include(locate_template('template-parts/image-slider.php'));
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
