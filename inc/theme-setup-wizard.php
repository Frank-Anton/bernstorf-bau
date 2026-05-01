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
            'content'  => '<p class="about-slogan"><em>Meisterqualität aus Überzeugung.</em></p>

<p>Ich bin <strong>Christian Bernstorf</strong>, Maurer- und Betonbauermeister. Mein Anspruch: Handwerk ohne Kompromisse. In und um Lüneburg stehe ich für Zuverlässigkeit, saubere Baustellen und Lösungen, die technisch wie optisch überzeugen. Bei mir bekommen Sie Beratung vom Chef und Qualität vom Meister.</p>

<h3>Was uns auszeichnet</h3>
<ul>
<li>Persönliche Beratung direkt vom Meister</li>
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
            'content'  => '<h2>Angaben gemäß § 5 TMG</h2>
<p>Bernstorf-Bau<br>
Christian Bernstorf<br>
Otto-Snell-Straße 2<br>
21339 Lüneburg</p>

<h2>Kontakt</h2>
<p>Telefon: <a href="tel:+4915227140 98">01522 - 27 14 098</a><br>
E-Mail: <a href="mailto:info@bernstorf-bau.de">info@bernstorf-bau.de</a></p>

<h2>Steuernummer</h2>
<p>33/103/05181-3304</p>

<p><em>Hinweis nach § 19 UStG: Aufgrund der Kleinunternehmerregelung weisen wir keine Umsatzsteuer aus.</em></p>

<h2>Berufsbezeichnung und berufsrechtliche Regelungen</h2>
<p>Berufsbezeichnung: Maurer- und Betonbauermeister<br>
Zuständige Kammer: Handwerkskammer Braunschweig-Lüneburg-Stade<br>
Verliehen in: Bundesrepublik Deutschland</p>
<p>Es gelten folgende berufsrechtliche Regelungen: Handwerksordnung (HwO), einsehbar unter <a href="https://www.gesetze-im-internet.de/hwo/" target="_blank" rel="noopener">www.gesetze-im-internet.de/hwo</a></p>

<h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
<p>Christian Bernstorf<br>
Otto-Snell-Straße 2<br>
21339 Lüneburg</p>

<h2>EU-Streitschlichtung</h2>
<p>Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit: <a href="https://ec.europa.eu/consumers/odr/" target="_blank" rel="noopener">https://ec.europa.eu/consumers/odr/</a>.<br>
Unsere E-Mail-Adresse finden Sie oben im Impressum.</p>

<h2>Verbraucherstreitbeilegung / Universalschlichtungsstelle</h2>
<p>Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.</p>

<h2>Haftung für Inhalte</h2>
<p>Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.</p>
<p>Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p>

<h2>Haftung für Links</h2>
<p>Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.</p>

<h2>Urheberrecht</h2>
<p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.</p>',
        ),
        'datenschutz' => array(
            'title'    => 'Datenschutzerklärung',
            'template' => '',
            'content'  => '<h2>1. Datenschutz auf einen Blick</h2>

<h3>Allgemeine Hinweise</h3>
<p>Die folgenden Hinweise geben einen einfachen Überblick darüber, was mit Ihren personenbezogenen Daten passiert, wenn Sie diese Website besuchen. Personenbezogene Daten sind alle Daten, mit denen Sie persönlich identifiziert werden können.</p>

<h3>Datenerfassung auf dieser Website</h3>
<p><strong>Wer ist verantwortlich für die Datenerfassung auf dieser Website?</strong><br>
Die Datenverarbeitung auf dieser Website erfolgt durch den Websitebetreiber. Dessen Kontaktdaten können Sie dem Abschnitt "Hinweis zur Verantwortlichen Stelle" in dieser Datenschutzerklärung entnehmen.</p>

<p><strong>Wie erfassen wir Ihre Daten?</strong><br>
Ihre Daten werden zum einen dadurch erhoben, dass Sie uns diese mitteilen. Hierbei kann es sich z.B. um Daten handeln, die Sie in unser Kontaktformular eingeben. Andere Daten werden automatisch oder nach Ihrer Einwilligung beim Besuch der Website durch unsere IT-Systeme erfasst. Das sind vor allem technische Daten (z.B. Internetbrowser, Betriebssystem oder Uhrzeit des Seitenaufrufs).</p>

<p><strong>Wofür nutzen wir Ihre Daten?</strong><br>
Ein Teil der Daten wird erhoben, um eine fehlerfreie Bereitstellung der Website zu gewährleisten. Andere Daten können zur Bearbeitung Ihrer Anfrage genutzt werden.</p>

<p><strong>Welche Rechte haben Sie bezüglich Ihrer Daten?</strong><br>
Sie haben jederzeit das Recht, unentgeltlich Auskunft über Herkunft, Empfänger und Zweck Ihrer gespeicherten personenbezogenen Daten zu erhalten. Sie haben außerdem ein Recht, die Berichtigung oder Löschung dieser Daten zu verlangen. Wenn Sie eine Einwilligung zur Datenverarbeitung erteilt haben, können Sie diese Einwilligung jederzeit für die Zukunft widerrufen. Außerdem haben Sie das Recht, unter bestimmten Umständen die Einschränkung der Verarbeitung Ihrer personenbezogenen Daten zu verlangen. Des Weiteren steht Ihnen ein Beschwerderecht bei der zuständigen Aufsichtsbehörde zu.</p>

<h2>2. Hosting</h2>
<p>Wir hosten die Inhalte unserer Website bei folgendem Anbieter:</p>

<h3>All-Inkl</h3>
<p>Anbieter ist die ALL-INKL.COM &ndash; Neue Medien Münnich, Inh. René Münnich, Hauptstraße 68, 02742 Friedersdorf (nachfolgend "All-Inkl").</p>
<p>Details entnehmen Sie der Datenschutzerklärung von All-Inkl: <a href="https://all-inkl.com/datenschutzinformationen/" target="_blank" rel="noopener">https://all-inkl.com/datenschutzinformationen/</a>.</p>
<p>Die Verwendung von All-Inkl erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Wir haben ein berechtigtes Interesse an einer möglichst zuverlässigen Darstellung unserer Website. Sofern eine entsprechende Einwilligung abgefragt wurde, erfolgt die Verarbeitung ausschließlich auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO und § 25 Abs. 1 TTDSG.</p>
<p><strong>Auftragsverarbeitung:</strong> Wir haben einen Vertrag über Auftragsverarbeitung (AVV) zur Nutzung des oben genannten Dienstes geschlossen.</p>

<h2>3. Allgemeine Hinweise und Pflichtinformationen</h2>

<h3>Datenschutz</h3>
<p>Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Wir behandeln Ihre personenbezogenen Daten vertraulich und entsprechend der gesetzlichen Datenschutzvorschriften sowie dieser Datenschutzerklärung.</p>

<h3>Hinweis zur verantwortlichen Stelle</h3>
<p>Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
<p>Bernstorf-Bau<br>
Christian Bernstorf<br>
Otto-Snell-Straße 2<br>
21339 Lüneburg<br><br>
Telefon: 01522 - 27 14 098<br>
E-Mail: info@bernstorf-bau.de</p>
<p>Verantwortliche Stelle ist die natürliche oder juristische Person, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten (z.B. Namen, E-Mail-Adressen o. Ä.) entscheidet.</p>

<h3>Speicherdauer</h3>
<p>Soweit innerhalb dieser Datenschutzerklärung keine speziellere Speicherdauer genannt wurde, verbleiben Ihre personenbezogenen Daten bei uns, bis der Zweck für die Datenverarbeitung entfällt. Wenn Sie ein berechtigtes Löschersuchen geltend machen oder eine Einwilligung zur Datenverarbeitung widerrufen, werden Ihre Daten gelöscht, sofern wir keine anderen rechtlich zulässigen Gründe für die Speicherung Ihrer personenbezogenen Daten haben (z.B. steuer- oder handelsrechtliche Aufbewahrungsfristen).</p>

<h3>SSL- bzw. TLS-Verschlüsselung</h3>
<p>Diese Seite nutzt aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher Inhalte eine SSL- bzw. TLS-Verschlüsselung. Eine verschlüsselte Verbindung erkennen Sie daran, dass die Adresszeile des Browsers von "http://" auf "https://" wechselt und an dem Schloss-Symbol in Ihrer Browserzeile.</p>

<h3>Auskunft, Löschung und Berichtigung</h3>
<p>Sie haben im Rahmen der geltenden gesetzlichen Bestimmungen jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit an uns wenden.</p>

<h2>4. Datenerfassung auf dieser Website</h2>

<h3>Cookies</h3>
<p>Unsere Internetseiten verwenden so genannte "Cookies". Cookies sind kleine Datenpakete und richten auf Ihrem Endgerät keinen Schaden an. Sie werden entweder vorübergehend für die Dauer einer Sitzung (Session-Cookies) oder dauerhaft (permanente Cookies) auf Ihrem Endgerät gespeichert.</p>
<p>Cookies haben verschiedene Funktionen. Zahlreiche Cookies sind technisch notwendig, da bestimmte Websitefunktionen ohne diese nicht funktionieren würden. Andere Cookies können zur Auswertung des Nutzerverhaltens oder zu Werbezwecken verwendet werden.</p>
<p>Cookies, die zur Durchführung des elektronischen Kommunikationsvorgangs, zur Bereitstellung bestimmter, von Ihnen erwünschter Funktionen erforderlich sind, werden auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO gespeichert. Soweit eine entsprechende Einwilligung abgefragt wurde, erfolgt die Verarbeitung ausschließlich auf Grundlage von Art. 6 Abs. 1 lit. a DSGVO und § 25 Abs. 1 TTDSG.</p>
<p>Sie können Ihre Cookie-Einstellungen jederzeit anpassen oder widerrufen.</p>

<h3>Server-Log-Dateien</h3>
<p>Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log-Dateien, die Ihr Browser automatisch an uns übermittelt. Dies sind:</p>
<ul>
<li>Browsertyp und Browserversion</li>
<li>verwendetes Betriebssystem</li>
<li>Referrer URL</li>
<li>Hostname des zugreifenden Rechners</li>
<li>Uhrzeit der Serveranfrage</li>
<li>IP-Adresse</li>
</ul>
<p>Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen.</p>
<p>Die Erfassung dieser Daten erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der technisch fehlerfreien Darstellung und der Optimierung seiner Website &ndash; hierzu müssen die Server-Log-Files erfasst werden.</p>

<h3>Kontaktformular</h3>
<p>Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.</p>
<p>Die Verarbeitung dieser Daten erfolgt auf Grundlage von Art. 6 Abs. 1 lit. b DSGVO, sofern Ihre Anfrage mit der Erfüllung eines Vertrags zusammenhängt oder zur Durchführung vorvertraglicher Maßnahmen erforderlich ist. In allen übrigen Fällen beruht die Verarbeitung auf unserem berechtigten Interesse an der effektiven Bearbeitung der an uns gerichteten Anfragen (Art. 6 Abs. 1 lit. f DSGVO) oder auf Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO), sofern diese abgefragt wurde.</p>
<p>Die von Ihnen im Kontaktformular eingegebenen Daten verbleiben bei uns, bis Sie uns zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder der Zweck für die Datenspeicherung entfällt (z.B. nach abgeschlossener Bearbeitung Ihrer Anfrage). Zwingende gesetzliche Bestimmungen &ndash; insbesondere Aufbewahrungsfristen &ndash; bleiben unberührt.</p>

<h3>Anfrage per E-Mail oder Telefon</h3>
<p>Wenn Sie uns per E-Mail oder Telefon kontaktieren, wird Ihre Anfrage inklusive aller daraus hervorgehenden personenbezogenen Daten (Name, Anfrage) zum Zwecke der Bearbeitung Ihres Anliegens bei uns gespeichert und verarbeitet. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.</p>

<p><em>Stand: April 2026</em></p>',
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
