<?php
/**
 * Template Name: Startseite
 * Front Page Template
 */
get_header();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero__slides" id="hero-slides">
        <?php
        $slides = new WP_Query(array(
            'post_type'      => 'hero_slide',
            'posts_per_page' => 5,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ));

        if ($slides->have_posts()) :
            $i = 0;
            while ($slides->have_posts()) : $slides->the_post();
                $image = get_the_post_thumbnail_url(get_the_ID(), 'hero-slide');
                $subtitle = get_post_meta(get_the_ID(), '_hero_subtitle', true);
                ?>
                <div class="hero__slide<?php echo $i === 0 ? ' active' : ''; ?>" style="background-image: url('<?php echo esc_url($image); ?>')"></div>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <div class="hero__slide active" style="background-color: var(--color-text);"></div>
        <?php endif; ?>
    </div>

    <div class="hero__overlay"></div>

    <div class="container">
        <div class="hero__content">
            <h1>Ihr Maurer- &amp; <span>Betonbauermeister</span> in und um L&uuml;neburg</h1>
            <p>Ob Neubau, Umbau oder Sanierung &ndash; wir bieten Ihnen professionelle L&ouml;sungen in den Bereichen Maurerarbeiten, Putzarbeiten und vieles mehr.</p>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakt'))); ?>" class="btn btn--primary">Jetzt anfragen</a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('leistungen'))); ?>" class="btn btn--outline">Unsere Leistungen</a>
        </div>
    </div>

    <?php if ($slides->post_count > 1) : ?>
    <div class="hero__dots" id="hero-dots">
        <?php for ($j = 0; $j < $slides->post_count; $j++) : ?>
            <button class="hero__dot<?php echo $j === 0 ? ' active' : ''; ?>" data-slide="<?php echo $j; ?>" aria-label="Slide <?php echo $j + 1; ?>"></button>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Leistungen Section -->
<section class="section" id="leistungen">
    <div class="container">
        <div class="section__header">
            <h2>Unsere Leistungen</h2>
            <p>Kompetenz und Qualit&auml;t in allen Bereichen des Bauhandwerks</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-card__icon"><?php echo bernstorf_icon('wall'); ?></div>
                <h3>Maurerarbeiten</h3>
                <p>Fachgerechte Mauerwerksarbeiten f&uuml;r Neubau und Bestand &ndash; zuverl&auml;ssig und pr&auml;zise.</p>
            </div>

            <div class="service-card">
                <div class="service-card__icon"><?php echo bernstorf_icon('trowel'); ?></div>
                <h3>Putzarbeiten</h3>
                <p>Innen- und Au&szlig;enputz f&uuml;r ein perfektes Finish Ihrer W&auml;nde und Fassaden.</p>
            </div>

            <div class="service-card">
                <div class="service-card__icon"><?php echo bernstorf_icon('house'); ?></div>
                <h3>Neubau</h3>
                <p>Von der Bodenplatte bis zum Dach &ndash; wir realisieren Ihr Bauprojekt.</p>
            </div>

            <div class="service-card">
                <div class="service-card__icon"><?php echo bernstorf_icon('repair'); ?></div>
                <h3>Sanierung</h3>
                <p>Altbausanierung, Schimmelsanierung und Kellerabdichtung aus einer Hand.</p>
            </div>

            <div class="service-card">
                <div class="service-card__icon"><?php echo bernstorf_icon('building'); ?></div>
                <h3>Um- &amp; Anbau</h3>
                <p>Wir erweitern und ver&auml;ndern Ihre Immobilie nach Ihren W&uuml;nschen.</p>
            </div>

            <div class="service-card">
                <div class="service-card__icon"><?php echo bernstorf_icon('shield'); ?></div>
                <h3>WDVS &amp; D&auml;mmung</h3>
                <p>W&auml;rmed&auml;mmverbundsysteme f&uuml;r energieeffizientes Wohnen.</p>
            </div>
        </div>
    </div>
</section>

<!-- Slogan-Trenner -->
<section class="slogan-banner">
    <div class="container">
        <p>Handwerk mit Herz und Verstand &ndash; f&uuml;r Projekte, die bleiben.</p>
    </div>
</section>

<!-- Über uns Teaser -->
<section class="section section--gray" id="ueber-uns">
    <div class="container">
        <div class="about-teaser">
            <div class="about-teaser__image">
                <?php
                $about_page = get_page_by_path('ueber-uns');
                if ($about_page && has_post_thumbnail($about_page->ID)) :
                    echo get_the_post_thumbnail($about_page->ID, 'large');
                else :
                    ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/placeholder-about.jpg'); ?>" alt="&Uuml;ber Bernstorf Bau">
                <?php endif; ?>
            </div>
            <div class="about-teaser__content">
                <?php $owner = get_theme_mod('bernstorf_owner', 'Christian Bernstorf'); ?>
                <h2>&Uuml;ber Bernstorf Bau</h2>
                <p>Hinter Bernstorf Bau steht <strong><?php echo esc_html($owner); ?></strong> &ndash; Ihr direkter Ansprechpartner f&uuml;r alle Bauvorhaben in und um L&uuml;neburg. Als kleines, engagiertes Team setzen wir auf pers&ouml;nliche Betreuung, kurze Wege und saubere Arbeit.</p>
                <p>Unsere Expertise reicht von Ab- und Durchbrucharbeiten bis hin zu Fassadensanierungen und Altbausanierungen.</p>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('ueber-uns'))); ?>" class="btn btn--outline-dark">Mehr erfahren</a>
            </div>
        </div>
    </div>
</section>

<!-- Projekte Section -->
<section class="section" id="projekte">
    <div class="container">
        <div class="section__header">
            <h2>Unsere Projekte</h2>
            <p>&Uuml;berzeugen Sie sich von unserer Arbeit</p>
        </div>

        <div class="projects-grid">
            <?php
            $projekte = new WP_Query(array(
                'post_type'      => 'projekt',
                'posts_per_page' => 6,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));

            if ($projekte->have_posts()) :
                while ($projekte->have_posts()) : $projekte->the_post();
                    ?>
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
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p style="text-align:center; grid-column: 1/-1; color: var(--color-text-light);">Projekte werden in K&uuml;rze hinzugef&uuml;gt.</p>
            <?php endif; ?>
        </div>

        <?php if ($projekte->found_posts > 6) : ?>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?php echo esc_url(get_post_type_archive_link('projekt')); ?>" class="btn btn--outline-dark">Alle Projekte ansehen</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <h2>Haben Sie ein Bauprojekt?</h2>
        <p>Kontaktieren Sie uns f&uuml;r eine kostenlose und unverbindliche Beratung. Wir freuen uns auf Ihr Projekt!</p>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakt'))); ?>" class="btn btn--outline">Kontakt aufnehmen</a>
    </div>
</section>

<?php get_footer(); ?>
