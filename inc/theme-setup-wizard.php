<?php
/**
 * Bernstorf Bau - Einmaliges Setup
 *
 * Erstellt automatisch alle benötigten Seiten, Menüs und Einstellungen.
 * Wird nur einmal ausgeführt (beim Theme-Aktivieren) und zeigt dann
 * einen Admin-Hinweis mit dem Ergebnis.
 */

function bernstorf_run_setup() {
    // Nur einmal ausführen
    if (get_option('bernstorf_setup_done')) {
        return;
    }

    $results = array();

    // 1. Seiten anlegen
    $pages = array(
        'startseite' => array(
            'title'    => 'Startseite',
            'template' => '',
            'content'  => '',
        ),
        'leistungen' => array(
            'title'    => 'Leistungen',
            'template' => 'page-leistungen.php',
            'content'  => '',
        ),
        'ueber-uns' => array(
            'title'    => 'Über uns',
            'template' => '',
            'content'  => '<h2>Bernstorf Bau – Ihr Partner für Bau &amp; Sanierung in Lüneburg</h2>
<p>Hinter Bernstorf Bau steht Christian Bernstorf – mit Leidenschaft für Qualität und Handwerk. Als kleines, engagiertes Team setzen wir auf persönliche Betreuung, kurze Wege und saubere Arbeit.</p>
<p>Ob Neubau, Umbau oder Sanierung – wir bieten Ihnen professionelle Lösungen in den Bereichen Maurerarbeiten, Stahl- und Betonarbeiten, Trockenbau und vieles mehr. Unsere Expertise reicht von Ab- und Durchbrucharbeiten bis hin zu Fassadensanierungen und Altbausanierungen.</p>
<h3>Ihr Ansprechpartner</h3>
<p><strong>Christian Bernstorf</strong> – Inhaber und Ihr direkter Ansprechpartner für alle Bauvorhaben in und um Lüneburg.</p>
<h3>Was uns auszeichnet</h3>
<ul>
<li>Persönliche Beratung direkt vom Chef</li>
<li>Faire und transparente Preise</li>
<li>Termingerechte Ausführung</li>
<li>Saubere und zuverlässige Arbeit</li>
<li>Regionale Verbundenheit in Lüneburg und Umgebung</li>
</ul>',
        ),
        'projekte' => array(
            'title'    => 'Projekte',
            'template' => '',
            'content'  => '',
        ),
        'kontakt' => array(
            'title'    => 'Kontakt',
            'template' => 'page-kontakt.php',
            'content'  => '',
        ),
        'impressum' => array(
            'title'    => 'Impressum',
            'template' => '',
            'content'  => '<p><strong>Angaben gemäß § 5 TMG:</strong></p>
<p>Bernstorf Bau<br>
Christian Bernstorf<br>
[Straße Nr.]<br>
[PLZ] Lüneburg</p>
<p><strong>Kontakt:</strong><br>
Telefon: [Ihre Telefonnummer]<br>
E-Mail: [Ihre E-Mail]</p>
<p><strong>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:</strong><br>
Christian Bernstorf<br>
[Adresse wie oben]</p>
<p><strong>Umsatzsteuer-ID:</strong><br>
[Falls vorhanden]</p>
<p><em>Bitte ergänzen Sie dieses Impressum mit Ihren vollständigen Angaben.</em></p>',
        ),
        'datenschutz' => array(
            'title'    => 'Datenschutzerklärung',
            'template' => '',
            'content'  => '<p><em>Bitte fügen Sie hier Ihre Datenschutzerklärung ein. Sie können einen Generator wie z.B. den von der Deutschen Gesellschaft für Datenschutz verwenden.</em></p>',
        ),
    );

    $page_ids = array();

    foreach ($pages as $slug => $page_data) {
        // Prüfen ob Seite bereits existiert
        $existing = get_page_by_path($slug);
        if ($existing) {
            $page_ids[$slug] = $existing->ID;
            $results[] = "Seite '{$page_data['title']}' existiert bereits (ID: {$existing->ID})";
            continue;
        }

        $page_id = wp_insert_post(array(
            'post_title'   => $page_data['title'],
            'post_name'    => $slug,
            'post_content' => $page_data['content'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ));

        if ($page_id && !is_wp_error($page_id)) {
            $page_ids[$slug] = $page_id;
            if (!empty($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
            $results[] = "Seite '{$page_data['title']}' erstellt (ID: {$page_id})";
        }
    }

    // 2. Startseite und Beitragsseite konfigurieren
    if (isset($page_ids['startseite'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_ids['startseite']);
        $results[] = "Startseite als statische Seite gesetzt";
    }

    // 3. Hauptmenü erstellen
    $menu_name = 'Hauptnavigation';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        if (!is_wp_error($menu_id)) {
            $menu_items = array(
                'startseite' => 'Startseite',
                'leistungen' => 'Leistungen',
                'projekte'   => 'Projekte',
                'ueber-uns'  => 'Über uns',
                'kontakt'    => 'Kontakt',
            );

            $position = 1;
            foreach ($menu_items as $slug => $title) {
                if (isset($page_ids[$slug])) {
                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title'     => $title,
                        'menu-item-object'    => 'page',
                        'menu-item-object-id' => $page_ids[$slug],
                        'menu-item-type'      => 'post_type',
                        'menu-item-status'    => 'publish',
                        'menu-item-position'  => $position,
                    ));
                    $position++;
                }
            }

            // Menü den Theme-Locations zuweisen
            $locations = get_theme_mod('nav_menu_locations');
            $locations['primary'] = $menu_id;
            $locations['footer'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);

            $results[] = "Hauptmenü erstellt und zugewiesen";
        }
    } else {
        $results[] = "Hauptmenü existiert bereits";
    }

    // 4. Permalink-Struktur setzen
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
    $results[] = "Permalink-Struktur auf 'Beitragsname' gesetzt";

    // 5. Blogname / Beschreibung
    update_option('blogname', 'Bernstorf Bau');
    update_option('blogdescription', 'Ihr Partner für Bau & Sanierung');
    $results[] = "Seitentitel und Beschreibung gesetzt";

    // 6. Zeitzone und Sprache
    update_option('timezone_string', 'Europe/Berlin');
    update_option('date_format', 'd.m.Y');
    update_option('time_format', 'H:i');
    $results[] = "Zeitzone auf Europe/Berlin gesetzt";

    // 7. Kommentare standardmäßig deaktivieren
    update_option('default_comment_status', 'closed');
    update_option('default_ping_status', 'closed');
    $results[] = "Kommentare standardmäßig deaktiviert";

    // Setup als erledigt markieren
    update_option('bernstorf_setup_done', true);
    update_option('bernstorf_setup_results', $results);
}
add_action('after_switch_theme', 'bernstorf_run_setup');

// Fallback: auch beim ersten Admin-Aufruf ausführen (falls Theme per DB aktiviert wurde)
function bernstorf_run_setup_on_admin() {
    if (!get_option('bernstorf_setup_done') && current_user_can('manage_options')) {
        bernstorf_run_setup();
    }
}
add_action('admin_init', 'bernstorf_run_setup_on_admin');

/**
 * Admin-Hinweis nach dem Setup
 */
function bernstorf_setup_admin_notice() {
    $results = get_option('bernstorf_setup_results');
    if (!$results) {
        return;
    }

    echo '<div class="notice notice-success is-dismissible">';
    echo '<p><strong>Bernstorf Bau Theme - Setup abgeschlossen!</strong></p>';
    echo '<ul style="list-style: disc; padding-left: 20px;">';
    foreach ($results as $result) {
        echo '<li>' . esc_html($result) . '</li>';
    }
    echo '</ul>';
    echo '<p><strong>Nächste Schritte:</strong></p>';
    echo '<ol>';
    echo '<li>Kontaktdaten im <a href="' . esc_url(admin_url('customize.php')) . '">Customizer</a> eintragen (Telefon, E-Mail, Adresse)</li>';
    echo '<li><a href="' . esc_url(admin_url('post-new.php?post_type=hero_slide')) . '">Hero Slides</a> mit Bildern anlegen</li>';
    echo '<li><a href="' . esc_url(admin_url('post-new.php?post_type=projekt')) . '">Projekte</a> hinzufügen</li>';
    echo '<li><a href="' . esc_url(admin_url('post.php?action=edit&post=' . get_option('page_on_front'))) . '">Impressum</a> und <a href="' . esc_url(get_edit_post_link(get_page_by_path('datenschutz'))) . '">Datenschutz</a> vervollständigen</li>';
    echo '</ol>';
    echo '</div>';

    // Hinweis nur einmal zeigen
    delete_option('bernstorf_setup_results');
}
add_action('admin_notices', 'bernstorf_setup_admin_notice');

/**
 * Manuelles Setup über Admin-Menü (falls nötig)
 */
function bernstorf_add_setup_menu() {
    if (get_option('bernstorf_setup_done')) {
        return;
    }

    add_theme_page(
        'Theme Setup',
        'Theme Setup',
        'manage_options',
        'bernstorf-setup',
        'bernstorf_setup_page'
    );
}
add_action('admin_menu', 'bernstorf_add_setup_menu');

function bernstorf_setup_page() {
    if (isset($_POST['bernstorf_run_setup']) && wp_verify_nonce($_POST['_wpnonce'], 'bernstorf_run_setup')) {
        bernstorf_run_setup();
        echo '<div class="notice notice-success"><p>Setup wurde ausgeführt! <a href="' . esc_url(admin_url()) . '">Zum Dashboard</a></p></div>';
        return;
    }
    ?>
    <div class="wrap">
        <h1>Bernstorf Bau - Theme Setup</h1>
        <p>Klicken Sie auf den Button, um alle Seiten, Menüs und Einstellungen automatisch anzulegen.</p>
        <form method="post">
            <?php wp_nonce_field('bernstorf_run_setup'); ?>
            <input type="hidden" name="bernstorf_run_setup" value="1">
            <?php submit_button('Setup jetzt ausführen', 'primary', 'submit', false); ?>
        </form>
    </div>
    <?php
}
