<?php
/**
 * 404 Template
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1>Seite nicht gefunden</h1>
    </div>
</div>

<div class="page-content" style="text-align: center; min-height: 40vh; display: flex; align-items: center;">
    <div class="container">
        <p style="font-size: 4rem; font-weight: 700; color: var(--color-primary); margin-bottom: 1rem;">404</p>
        <p style="font-size: 1.2rem; color: var(--color-text-light); margin-bottom: 2rem;">Die angeforderte Seite konnte leider nicht gefunden werden.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">Zur Startseite</a>
    </div>
</div>

<?php get_footer(); ?>
