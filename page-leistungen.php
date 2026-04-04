<?php
/**
 * Template Name: Leistungen
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1>Unsere Leistungen</h1>
        <p>Kompetenz und Qualit&auml;t in allen Bereichen des Bauhandwerks</p>
        <div class="page-header__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Startseite</a> &raquo; <span>Leistungen</span>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="services-list">
            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('wall'); ?></div>
                <div>
                    <h3>Maurerarbeiten</h3>
                    <p>Fachgerechte Mauerwerksarbeiten f&uuml;r Neubau, Umbau und Sanierung. Wir erstellen tragende und nichttragende W&auml;nde mit h&ouml;chster Pr&auml;zision.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('trowel'); ?></div>
                <div>
                    <h3>Putzarbeiten</h3>
                    <p>Innen- und Au&szlig;enputz in verschiedenen Techniken und Qualit&auml;ten. Vom Grundputz bis zum dekorativen Oberputz.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('repair'); ?></div>
                <div>
                    <h3>Sanierung</h3>
                    <p>Umfassende Sanierungsarbeiten f&uuml;r Bestandsgeb&auml;ude. Wir bringen Ihre Immobilie auf den neuesten Stand.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('house'); ?></div>
                <div>
                    <h3>Neubau</h3>
                    <p>Vom Fundament bis zur fertigen H&uuml;lle &ndash; wir begleiten Ihren Neubau mit fachlicher Kompetenz.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('building'); ?></div>
                <div>
                    <h3>Um- &amp; Anbau</h3>
                    <p>Erweiterungen, Umbauten und r&auml;umliche Ver&auml;nderungen an Ihrem bestehenden Geb&auml;ude.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('repair'); ?></div>
                <div>
                    <h3>Altbausanierung</h3>
                    <p>Behutsame und fachgerechte Sanierung von Altbauten unter Ber&uuml;cksichtigung der Bausubstanz.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('shield'); ?></div>
                <div>
                    <h3>WDVS</h3>
                    <p>W&auml;rmed&auml;mmverbundsysteme f&uuml;r energieeffizientes Wohnen und geringere Heizkosten.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('repair'); ?></div>
                <div>
                    <h3>Schornsteinsanierung</h3>
                    <p>Professionelle Sanierung und Instandsetzung von Schornsteinen und Kaminen.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('shield'); ?></div>
                <div>
                    <h3>Schimmelsanierung</h3>
                    <p>Ursachenforschung und nachhaltige Beseitigung von Schimmelbefall in Wohn- und Gewerber&auml;umen.</p>
                </div>
            </div>

            <div class="service-detail">
                <div class="service-detail__icon"><?php echo bernstorf_icon('shield'); ?></div>
                <div>
                    <h3>Kellerabdichtung</h3>
                    <p>Fachgerechte Abdichtung von Kellern gegen dr&uuml;ckendes und nichtdr&uuml;ckendes Wasser.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h2>Interesse an unseren Leistungen?</h2>
        <p>Kontaktieren Sie uns f&uuml;r eine kostenlose Beratung und ein unverbindliches Angebot.</p>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakt'))); ?>" class="btn btn--outline">Jetzt anfragen</a>
    </div>
</section>

<?php get_footer(); ?>
