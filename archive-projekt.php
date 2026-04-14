<?php
/**
 * Projekte Archive Template
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1>Unsere Projekte</h1>
        <p>&Uuml;berzeugen Sie sich von unserer Arbeit</p>
        <div class="page-header__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Startseite</a> &raquo; <span>Projekte</span>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="projects-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="project-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('project-thumb'); ?>
                        <?php endif; ?>
                        <div class="project-card__overlay">
                            <h3><?php the_title(); ?></h3>
                            <?php if (has_excerpt()) : ?>
                                <p><?php echo esc_html(get_the_excerpt()); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '&laquo; Zur&uuml;ck',
                    'next_text' => 'Weiter &raquo;',
                ));
                ?>
            </div>
        <?php else : ?>
            <p style="text-align: center; color: var(--color-text-light);">Noch keine Projekte vorhanden.</p>
        <?php endif; ?>
    </div>
</div>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h2>Lust auf ein solides Projekt?</h2>
        <p>Schreiben Sie mir oder rufen Sie direkt an &ndash; Beratung vom Chef, Qualit&auml;t vom Meister.</p>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakt'))); ?>" class="btn btn--outline">Kontakt aufnehmen</a>
    </div>
</section>

<?php get_footer(); ?>
