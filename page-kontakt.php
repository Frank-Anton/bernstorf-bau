<?php
/**
 * Template Name: Kontakt
 */
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1>Kontakt</h1>
        <p>Wir freuen uns auf Ihre Anfrage</p>
        <div class="page-header__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Startseite</a> &raquo; <span>Kontakt</span>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="contact-section">
            <div class="contact-info">
                <h3>So erreichen Sie uns</h3>

                <?php $owner = get_theme_mod('bernstorf_owner', 'Christian Bernstorf'); ?>
                <?php if ($owner) : ?>
                <p style="font-size: 1.1rem; margin-bottom: 1.5rem;"><strong>Ihr Ansprechpartner:</strong><br><?php echo esc_html($owner); ?></p>
                <?php endif; ?>

                <?php $phone = get_theme_mod('bernstorf_phone', ''); ?>
                <?php if ($phone) : ?>
                <div class="contact-info__item">
                    <?php echo bernstorf_icon('phone'); ?>
                    <div>
                        <strong>Telefon</strong>
                        <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                    </div>
                </div>
                <?php endif; ?>

                <?php $email = get_theme_mod('bernstorf_email', ''); ?>
                <?php if ($email) : ?>
                <div class="contact-info__item">
                    <?php echo bernstorf_icon('mail'); ?>
                    <div>
                        <strong>E-Mail</strong>
                        <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                    </div>
                </div>
                <?php endif; ?>

                <?php
                $address = get_theme_mod('bernstorf_address', '');
                $city = get_theme_mod('bernstorf_city', '');
                ?>
                <?php if ($address) : ?>
                <div class="contact-info__item">
                    <?php echo bernstorf_icon('location'); ?>
                    <div>
                        <strong>Adresse</strong>
                        <p><?php echo esc_html($address); ?><?php if ($city) echo '<br>' . esc_html($city); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <div style="margin-top: 2rem;">
                    <h3>&Ouml;ffnungszeiten</h3>
                    <p><strong>Mo &ndash; Fr:</strong> 07:00 &ndash; 17:00 Uhr</p>
                    <p><strong>Sa &ndash; So:</strong> Nach Vereinbarung</p>
                </div>
            </div>

            <div class="contact-form">
                <h3>Schreiben Sie uns</h3>
                <div id="contact-form-messages"></div>

                <form id="bernstorf-contact-form" method="post">
                    <?php wp_nonce_field('bernstorf_contact_nonce', 'contact_nonce'); ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-name">Name *</label>
                            <input type="text" id="contact-name" name="contact_name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-email">E-Mail *</label>
                            <input type="email" id="contact-email" name="contact_email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact-phone">Telefon</label>
                        <input type="tel" id="contact-phone" name="contact_phone">
                    </div>

                    <div class="form-group">
                        <label for="contact-subject">Betreff</label>
                        <select id="contact-subject" name="contact_subject">
                            <option value="">Bitte w&auml;hlen...</option>
                            <option value="Anfrage Neubau">Anfrage Neubau</option>
                            <option value="Anfrage Sanierung">Anfrage Sanierung</option>
                            <option value="Anfrage Umbau">Anfrage Umbau</option>
                            <option value="Kostenvoranschlag">Kostenvoranschlag</option>
                            <option value="Sonstiges">Sonstiges</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact-message">Nachricht *</label>
                        <textarea id="contact-message" name="contact_message" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="contact_privacy" required>
                            Ich habe die <a href="<?php echo esc_url(get_permalink(get_page_by_path('datenschutz'))); ?>" target="_blank">Datenschutzerkl&auml;rung</a> gelesen und stimme der Verarbeitung meiner Daten zu. *
                        </label>
                    </div>

                    <!-- Honeypot -->
                    <div style="position:absolute;left:-9999px;" aria-hidden="true">
                        <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn--primary">Nachricht senden</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
