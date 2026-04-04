<?php
/**
 * Main Index Template
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1><?php bloginfo('name'); ?></h1>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Keine Beitr&auml;ge gefunden.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
