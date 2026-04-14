<?php
/**
 * Template Name: Leistungen
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1>Unsere Leistungen</h1>
        <p>Handwerk ohne Kompromisse &ndash; vom Fundament bis zur fertigen Fassade.</p>
        <div class="page-header__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Startseite</a> &raquo; <span>Leistungen</span>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="leistung-blocks">

            <!-- Block 1: Maurer- & Betonarbeiten -->
            <article class="leistung-block" id="maurerarbeiten">
                <div class="leistung-block__head">
                    <div class="leistung-block__icon"><?php echo bernstorf_icon('wall'); ?></div>
                    <div>
                        <span class="leistung-block__label">Maurer- &amp; Betonarbeiten</span>
                        <h2>Das Fundament f&uuml;r Generationen.</h2>
                    </div>
                </div>
                <p class="leistung-block__intro">Ein Haus ist nur so gut wie sein Rohbau. Ob Sie ein neues Zuhause planen, eine Garage anbauen oder eine Grundst&uuml;cksmauer errichten m&ouml;chten &ndash; das Maurerhandwerk ist unsere Kernkompetenz. Wir arbeiten nach modernsten Standards und mit h&ouml;chster Ma&szlig;genauigkeit.</p>
                <div class="leistung-block__grid">
                    <div class="leistung-info">
                        <h4>Unsere Leistungen</h4>
                        <p>Neubau von Einfamilienh&auml;usern, Erstellung von Fundamenten, fachgerechtes Verblendmauerwerk (Klinker) und Betonarbeiten aller Art.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Ihr Vorteil</h4>
                        <p>Wir achten auf bauphysikalische Details wie korrekte Abdichtungen und saubere Anschl&uuml;sse. Das spart Ihnen sp&auml;ter &Auml;rger und Kosten bei den Folgegewerken.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Das Ergebnis</h4>
                        <p>Massive Wertbest&auml;ndigkeit und eine Optik, die auch nach Jahrzehnten &uuml;berzeugt.</p>
                    </div>
                </div>
                <?php $slider_images = bernstorf_slider_images(array('maurerarbeiten', 'neubau'), 8); include(locate_template('template-parts/image-slider.php')); ?>
            </article>

            <!-- Block 2: Sanierung & Altbau -->
            <article class="leistung-block" id="sanierung">
                <div class="leistung-block__head">
                    <div class="leistung-block__icon"><?php echo bernstorf_icon('repair'); ?></div>
                    <div>
                        <span class="leistung-block__label">Sanierung &amp; Altbau-Instandsetzung</span>
                        <h2>Altes bewahren &ndash; mit modernem Verstand.</h2>
                    </div>
                </div>
                <p class="leistung-block__intro">L&uuml;neburg lebt von seiner Geschichte, und wir lieben es, diese zu erhalten. Doch die Sanierung von Altbauten erfordert Erfahrung mit historischen Baustoffen und den Mut, moderne Technik behutsam zu integrieren. Wir retten marode Substanz und machen sie bewohnbar.</p>
                <div class="leistung-block__grid">
                    <div class="leistung-info">
                        <h4>Unsere Leistungen</h4>
                        <p>Fachgerechte Schornsteinsanierung, Instandsetzung von Mauerwerkssch&auml;den, energetische Modernisierung und Denkmalschutz-gerechte Arbeiten.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Ihr Vorteil</h4>
                        <p>Wir erkennen fr&uuml;hzeitig, was erhalten werden kann und was ersetzt werden muss. Das gibt Ihnen Planungssicherheit bei Ihrem Sanierungsprojekt.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Das Ergebnis</h4>
                        <p>Ein Haus mit Seele, das energetisch und technisch auf dem Stand von heute ist.</p>
                    </div>
                </div>
                <?php $slider_images = bernstorf_slider_images(array('sanierung'), 8); include(locate_template('template-parts/image-slider.php')); ?>
            </article>

            <!-- Block 3: Kellerabdichtung & Trockenlegung -->
            <article class="leistung-block" id="keller">
                <div class="leistung-block__head">
                    <div class="leistung-block__icon"><?php echo bernstorf_icon('shield'); ?></div>
                    <div>
                        <span class="leistung-block__label">Kellerabdichtung &amp; Trockenlegung</span>
                        <h2>Wir machen Ihr Haus wieder gesund.</h2>
                    </div>
                </div>
                <p class="leistung-block__intro">Feuchtigkeit im Keller ist der Albtraum jedes Hausbesitzers. Sie greift die Bausubstanz an und gef&auml;hrdet durch Schimmelbildung die Gesundheit. Wir finden die Ursache &ndash; ob dr&uuml;ckendes Grundwasser, defekte Rohre oder fehlende Horizontalsperren &ndash; und l&ouml;sen das Problem dauerhaft.</p>
                <div class="leistung-block__grid">
                    <div class="leistung-info">
                        <h4>Unsere Leistungen</h4>
                        <p>Au&szlig;enabdichtungen (KMB/Bitumen), Einbau von Horizontalsperren gegen aufsteigende Feuchtigkeit und professionelle Schimmelsanierung.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Ihr Vorteil</h4>
                        <p>Wir "doktern" nicht an den Symptomen herum, sondern setzen an der Wurzel an. Damit Ihr Keller wieder als Lager- oder Wohnraum nutzbar wird.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Das Ergebnis</h4>
                        <p>Ein trockenes, gesundes Raumklima und ein langfristiger Schutz des Geb&auml;udewerts.</p>
                    </div>
                </div>
                <?php $slider_images = bernstorf_slider_images(array('sanierung'), 8); include(locate_template('template-parts/image-slider.php')); ?>
            </article>

            <!-- Block 4: Umbau, Anbau & Durchbrüche -->
            <article class="leistung-block" id="umbau">
                <div class="leistung-block__head">
                    <div class="leistung-block__icon"><?php echo bernstorf_icon('building'); ?></div>
                    <div>
                        <span class="leistung-block__label">Umbau, Anbau &amp; Durchbr&uuml;che</span>
                        <h2>Mehr Platz f&uuml;r Ihre Pl&auml;ne.</h2>
                    </div>
                </div>
                <p class="leistung-block__intro">Das Leben ver&auml;ndert sich: Die Kinder brauchen mehr Platz, das Home-Office zieht ein oder die K&uuml;che soll offen und modern werden. Wir schaffen den n&ouml;tigen Raum daf&uuml;r. Ein Wanddurchbruch oder ein Anbau klingt einfach, erfordert aber statisches Fachwissen und saubere Ausf&uuml;hrung.</p>
                <div class="leistung-block__grid">
                    <div class="leistung-info">
                        <h4>Unsere Leistungen</h4>
                        <p>Erstellung von T&uuml;r- und Fensterdurchbr&uuml;chen, Einbau von Stahltr&auml;gern, Erweiterung von Wohnfl&auml;chen durch Anbauten.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Ihr Vorteil</h4>
                        <p>Wir arbeiten extrem sauber und staubarm, damit der restliche Wohnbetrieb so wenig wie m&ouml;glich gest&ouml;rt wird.</p>
                    </div>
                    <div class="leistung-info">
                        <h4>Das Ergebnis</h4>
                        <p>Ein neues Wohngef&uuml;hl ohne die Sorgen eines kompletten Neubaus.</p>
                    </div>
                </div>
                <?php $slider_images = bernstorf_slider_images(array('maurerarbeiten', 'neubau'), 8); include(locate_template('template-parts/image-slider.php')); ?>
            </article>

        </div>
    </div>
</div>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h2>Lust auf ein solides Projekt?</h2>
        <p>Schreiben Sie mir oder rufen Sie direkt an &ndash; Beratung vom Chef, Qualit&auml;t vom Meister.</p>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakt'))); ?>" class="btn btn--outline">Jetzt anfragen</a>
    </div>
</section>

<?php get_footer(); ?>
