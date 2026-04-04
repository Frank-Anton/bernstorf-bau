<?php
/**
 * Contact Form Handler
 */

function bernstorf_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'bernstorf_contact_nonce')) {
        wp_send_json_error(array('message' => 'Sicherheitsüberprüfung fehlgeschlagen. Bitte laden Sie die Seite neu.'));
    }

    // Honeypot check
    if (!empty($_POST['website_url'])) {
        wp_send_json_error(array('message' => 'Spam erkannt.'));
    }

    // Validate required fields
    $name    = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $email   = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $phone   = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    $subject = isset($_POST['contact_subject']) ? sanitize_text_field($_POST['contact_subject']) : 'Kontaktanfrage';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => 'Bitte füllen Sie alle Pflichtfelder aus.'));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.'));
    }

    // Rate limiting (simple: max 3 submissions per hour per IP)
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'bernstorf_contact_' . md5($ip);
    $submissions = get_transient($transient_key);
    if ($submissions === false) {
        $submissions = 0;
    }
    if ($submissions >= 3) {
        wp_send_json_error(array('message' => 'Zu viele Anfragen. Bitte versuchen Sie es später erneut.'));
    }
    set_transient($transient_key, $submissions + 1, HOUR_IN_SECONDS);

    // Build email
    $to = get_option('admin_email');
    $site_name = get_bloginfo('name');
    $email_subject = "[{$site_name}] {$subject} - {$name}";

    $body = "Neue Kontaktanfrage über die Website:\n\n";
    $body .= "Name: {$name}\n";
    $body .= "E-Mail: {$email}\n";
    if ($phone) {
        $body .= "Telefon: {$phone}\n";
    }
    $body .= "Betreff: {$subject}\n\n";
    $body .= "Nachricht:\n{$message}\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    );

    $sent = wp_mail($to, $email_subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(array('message' => 'Vielen Dank für Ihre Nachricht! Wir melden uns schnellstmöglich bei Ihnen.'));
    } else {
        wp_send_json_error(array('message' => 'Leider konnte die Nachricht nicht gesendet werden. Bitte versuchen Sie es telefonisch.'));
    }
}
add_action('wp_ajax_bernstorf_contact', 'bernstorf_handle_contact_form');
add_action('wp_ajax_nopriv_bernstorf_contact', 'bernstorf_handle_contact_form');
