<?php
/**
 * Single Projekt Template
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <div class="page-header__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Startseite</a> &raquo;
            <a href="<?php echo esc_url(get_post_type_archive_link('projekt')); ?>">Projekte</a> &raquo;
            <span><?php the_title(); ?></span>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="projekt-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <?php
                $terms = get_the_terms(get_the_ID(), 'projekt_kategorie');
                if ($terms && !is_wp_error($terms)) :
                    ?>
                    <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--color-border);">
                        <strong>Kategorie:</strong>
                        <?php
                        $term_names = array_map(function ($term) {
                            return '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                        }, $terms);
                        echo implode(', ', $term_names);
                        ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>

        <div style="margin-top: 3rem; text-align: center;">
            <a href="<?php echo esc_url(get_post_type_archive_link('projekt')); ?>" class="btn btn--outline-dark">&larr; Alle Projekte</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
