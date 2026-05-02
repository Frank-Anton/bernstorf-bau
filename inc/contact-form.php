<?php
/**
 * Contact Form Handler
 *
 * Layered Defense:
 * 1. WP-Nonce (CSRF)
 * 2. Honeypot ("website_url")
 * 3. Time-Trap (signierter Zeitstempel, 3s min / 24h max)
 * 4. Server-seitige Consent-Pruefung (DSGVO)
 * 5. Input-Sanitisierung (mit wp_unslash)
 * 6. Rate-Limiting (3 pro Stunde pro IP)
 * 7. Sichere Mail-Header (Reply-To nur Email)
 * 8. wp_mail_failed-Hook fuer Admin-Notice
 */

const BERNSTORF_CONTACT_ACTION = 'bernstorf_contact';

function bernstorf_handle_contact_form() {
    // 1. Nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'bernstorf_contact_nonce')) {
        wp_send_json_error(array('message' => 'Sicherheitsüberprüfung fehlgeschlagen. Bitte laden Sie die Seite neu.'));
    }

    // 2. Honeypot - still ablehnen, kein Hinweis fuer Bots
    if (!empty($_POST['website_url'])) {
        wp_send_json_success(array('message' => 'Vielen Dank für Ihre Nachricht!'));
    }

    // 3. Time-Trap: Signatur + Mindest-/Maximalzeit
    $ts   = isset($_POST['ts'])   ? (int) $_POST['ts'] : 0;
    $tsig = isset($_POST['tsig']) ? sanitize_text_field(wp_unslash($_POST['tsig'])) : '';
    $expected_sig = wp_hash($ts . '|' . BERNSTORF_CONTACT_ACTION);

    if (!hash_equals($expected_sig, $tsig)) {
        // Signatur stimmt nicht - still als Erfolg melden
        wp_send_json_success(array('message' => 'Vielen Dank für Ihre Nachricht!'));
    }

    $elapsed = time() - $ts;
    if ($elapsed < 3) {
        // Zu schnell ausgefuellt - Bot-Verdacht, still als Erfolg melden
        wp_send_json_success(array('message' => 'Vielen Dank für Ihre Nachricht!'));
    }
    if ($elapsed > DAY_IN_SECONDS) {
        wp_send_json_error(array('message' => 'Das Formular ist abgelaufen. Bitte laden Sie die Seite neu.'));
    }

    // 4. Server-seitige Consent-Pruefung (DSGVO)
    if (empty($_POST['contact_privacy'])) {
        wp_send_json_error(array('message' => 'Bitte stimmen Sie der Datenschutzerklärung zu.'));
    }

    // 5. Input-Sanitisierung (wp_unslash zuerst!)
    $name    = isset($_POST['contact_name'])    ? sanitize_text_field(wp_unslash($_POST['contact_name']))       : '';
    $email   = isset($_POST['contact_email'])   ? sanitize_email(wp_unslash($_POST['contact_email']))           : '';
    $phone   = isset($_POST['contact_phone'])   ? sanitize_text_field(wp_unslash($_POST['contact_phone']))      : '';
    $subject = isset($_POST['contact_subject']) ? sanitize_text_field(wp_unslash($_POST['contact_subject']))    : 'Kontaktanfrage';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field(wp_unslash($_POST['contact_message'])) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => 'Bitte füllen Sie alle Pflichtfelder aus.'));
    }
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.'));
    }
    if (empty($subject)) {
        $subject = 'Kontaktanfrage';
    }

    // 6. Rate-Limiting (3 pro Stunde pro IP)
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    $transient_key = 'bernstorf_contact_' . md5($ip);
    $submissions = (int) get_transient($transient_key);
    if ($submissions >= 3) {
        wp_send_json_error(array('message' => 'Zu viele Anfragen. Bitte versuchen Sie es später erneut.'));
    }
    set_transient($transient_key, $submissions + 1, HOUR_IN_SECONDS);

    // E-Mail bauen
    $to = apply_filters('bernstorf_contact_recipient', get_option('admin_email'));
    $site_name = get_bloginfo('name');
    $email_subject = "[{$site_name}] {$subject} - {$name}";

    $body  = "Neue Kontaktanfrage über die Website:\n\n";
    $body .= "Name:    {$name}\n";
    $body .= "E-Mail:  {$email}\n";
    if ($phone) {
        $body .= "Telefon: {$phone}\n";
    }
    $body .= "Betreff: {$subject}\n\n";
    $body .= "Nachricht:\n{$message}\n";

    // 7. Sichere Mail-Header - Reply-To nur Email, kein Name
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email,
    );

    $sent = wp_mail($to, $email_subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(array('message' => 'Vielen Dank für Ihre Nachricht! Wir melden uns schnellstmöglich bei Ihnen.'));
    } else {
        wp_send_json_error(array('message' => 'Leider konnte die Nachricht nicht gesendet werden. Bitte versuchen Sie es telefonisch.'));
    }
}
add_action('wp_ajax_' . BERNSTORF_CONTACT_ACTION, 'bernstorf_handle_contact_form');
add_action('wp_ajax_nopriv_' . BERNSTORF_CONTACT_ACTION, 'bernstorf_handle_contact_form');

/**
 * 8. wp_mail_failed-Hook: Bei Mail-Fehlern in WP-Log schreiben + Option setzen
 *    fuer Admin-Notice im Backend.
 */
add_action('wp_mail_failed', function ($error) {
    $msg = $error->get_error_message();
    error_log('[Bernstorf-Bau] wp_mail failed: ' . $msg);
    update_option('bernstorf_last_mail_error', array(
        'time'    => time(),
        'message' => $msg,
    ));
});

/**
 * Admin-Notice falls letzter Mail-Versand fehlgeschlagen ist (innerhalb 24h)
 */
add_action('admin_notices', function () {
    if (!current_user_can('manage_options')) {
        return;
    }
    $err = get_option('bernstorf_last_mail_error');
    if (!$err || empty($err['time'])) {
        return;
    }
    if (time() - $err['time'] > DAY_IN_SECONDS) {
        return;
    }
    echo '<div class="notice notice-error is-dismissible">';
    echo '<p><strong>Bernstorf-Bau:</strong> Letzter Mail-Versand fehlgeschlagen ('
        . esc_html(human_time_diff($err['time'])) . ' her): '
        . esc_html($err['message'])
        . '</p><p>Pruefen Sie ggf. Ihre SMTP-Konfiguration (Plugin "WP Mail SMTP" empfohlen).</p>';
    echo '</div>';
});

/**
 * Helper: Erzeugt verstecktes ts + tsig Inputs-HTML fuer das Form
 */
function bernstorf_contact_time_trap_fields() {
    $ts  = time();
    $sig = wp_hash($ts . '|' . BERNSTORF_CONTACT_ACTION);
    echo '<input type="hidden" name="ts" value="' . esc_attr($ts) . '">';
    echo '<input type="hidden" name="tsig" value="' . esc_attr($sig) . '">';
}
