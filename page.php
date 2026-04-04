<?php
/**
 * Default Page Template
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
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
