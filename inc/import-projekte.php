<?php
/**
 * Bernstorf Bau - Projekt-Bilder Importer
 *
 * Importiert Bilder aus H:/ als Projekte mit Galerien.
 * Aufruf nur fuer Admins ueber Theme-Tools.
 */

function bernstorf_import_projekte() {
    if (!current_user_can('manage_options')) {
        wp_die('Keine Berechtigung.');
    }

    @set_time_limit(600);

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Mapping: Ordnername => array(Projekt-Titel, Projekt-Kategorie, Beschreibung)
    $folders = array(
        'Altbausanierung' => array(
            'title'    => 'Altbausanierung',
            'category' => 'Sanierung',
            'desc'     => 'Behutsame und fachgerechte Sanierung von Altbauten unter Beruecksichtigung der Bausubstanz.',
        ),
        'Aussenfassade Verputzen' => array(
            'title'    => 'Aussenfassade verputzen',
            'category' => 'Putzarbeiten',
            'desc'     => 'Aussenputz fuer ein perfektes Finish Ihrer Fassade.',
            'folder'   => 'Außenfassade Verputzen',
        ),
        'Balkon Sanierung' => array(
            'title'    => 'Balkonsanierung',
            'category' => 'Sanierung',
            'desc'     => 'Sanierung von Balkonen mit fachgerechter Abdichtung und neuem Aufbau.',
        ),
        'Brandschutzwaende' => array(
            'title'    => 'Brandschutzwaende',
            'category' => 'Maurerarbeiten',
            'desc'     => 'Errichtung von Brandschutzwaenden nach geltenden Vorschriften.',
            'folder'   => 'Brandschutzwände',
        ),
        'Durchbrueche' => array(
            'title'    => 'Durchbrueche',
            'category' => 'Maurerarbeiten',
            'desc'     => 'Wand- und Deckendurchbrueche fuer neue Raumkonzepte.',
            'folder'   => 'Durchbrüche',
        ),
        'Fachwerksanierung' => array(
            'title'    => 'Fachwerksanierung',
            'category' => 'Sanierung',
            'desc'     => 'Restaurierung und Sanierung historischer Fachwerkbauten.',
        ),
        'Fenster vergroessern verkleinern' => array(
            'title'    => 'Fenster vergroessern und verkleinern',
            'category' => 'Maurerarbeiten',
            'desc'     => 'Anpassung von Fenstereroeffnungen nach Ihren Wuenschen.',
            'folder'   => 'Fenster vergrößern+verkleinern',
        ),
        'Gartenmauern' => array(
            'title'    => 'Gartenmauern',
            'category' => 'Maurerarbeiten',
            'desc'     => 'Gestaltung und Bau von individuellen Gartenmauern.',
        ),
        'Lehmbau' => array(
            'title'    => 'Lehmbau',
            'category' => 'Sanierung',
            'desc'     => 'Oekologisches Bauen und Sanieren mit Lehm.',
        ),
        'Neubau' => array(
            'title'    => 'Neubau',
            'category' => 'Neubau',
            'desc'     => 'Vom Fundament bis zur fertigen Huelle - wir realisieren Ihren Neubau.',
        ),
        'Neubau mit Riemchen' => array(
            'title'    => 'Neubau mit Riemchen',
            'category' => 'Neubau',
            'desc'     => 'Neubau mit hochwertiger Riemchen-Verblendung.',
        ),
        'Putz arbeiten' => array(
            'title'    => 'Putzarbeiten',
            'category' => 'Putzarbeiten',
            'desc'     => 'Innen- und Aussenputz in verschiedenen Techniken und Qualitaeten.',
        ),
        'Quaderputz' => array(
            'title'    => 'Quaderputz',
            'category' => 'Putzarbeiten',
            'desc'     => 'Klassischer Quaderputz fuer eine elegante Fassadengestaltung.',
        ),
        'Schornsteinsanierung' => array(
            'title'    => 'Schornsteinsanierung',
            'category' => 'Sanierung',
            'desc'     => 'Professionelle Sanierung und Instandsetzung von Schornsteinen.',
        ),
        'Treppensanierung' => array(
            'title'    => 'Treppensanierung',
            'category' => 'Sanierung',
            'desc'     => 'Sanierung von Innen- und Aussentreppen.',
        ),
        'Verblend mauern' => array(
            'title'    => 'Verblendmauerwerk',
            'category' => 'Maurerarbeiten',
            'desc'     => 'Hochwertige Verblendmauerwerk-Arbeiten.',
        ),
        'WDVS' => array(
            'title'    => 'WDVS - Waermedaemmverbundsystem',
            'category' => 'Sanierung',
            'desc'     => 'Waermedaemmverbundsysteme fuer energieeffizientes Wohnen.',
        ),
    );

    $base_path = 'H:/';
    $max_images = 5;
    $log = array();

    foreach ($folders as $key => $info) {
        $folder_name = isset($info['folder']) ? $info['folder'] : $key;
        $folder_path = $base_path . $folder_name;

        if (!is_dir($folder_path)) {
            $log[] = "FEHLER: Ordner nicht gefunden: {$folder_name}";
            continue;
        }

        // Pruefen ob Projekt schon existiert
        $existing = get_page_by_title($info['title'], OBJECT, 'projekt');
        if ($existing) {
            $log[] = "Projekt '{$info['title']}' existiert bereits - uebersprungen.";
            continue;
        }

        // Bilder einsammeln (max 5)
        $files = glob($folder_path . '/*.{jpg,jpeg,png,JPG,JPEG,PNG}', GLOB_BRACE);
        if (empty($files)) {
            $log[] = "Keine Bilder in {$folder_name}";
            continue;
        }
        sort($files);
        $files = array_slice($files, 0, $max_images);

        // Kategorie-Term anlegen oder holen
        $term = term_exists($info['category'], 'projekt_kategorie');
        if (!$term) {
            $term = wp_insert_term($info['category'], 'projekt_kategorie');
        }
        $term_id = is_array($term) ? $term['term_id'] : $term;

        // Projekt-Post anlegen
        $project_id = wp_insert_post(array(
            'post_title'   => $info['title'],
            'post_status'  => 'publish',
            'post_type'    => 'projekt',
            'post_content' => '<p>' . $info['desc'] . '</p>',
            'post_excerpt' => $info['desc'],
        ));

        if (is_wp_error($project_id) || !$project_id) {
            $log[] = "FEHLER beim Anlegen des Projekts {$info['title']}";
            continue;
        }

        // Kategorie zuweisen
        wp_set_object_terms($project_id, intval($term_id), 'projekt_kategorie');

        // Bilder importieren
        $attachment_ids = array();
        foreach ($files as $file) {
            $attachment_id = bernstorf_import_image($file, $project_id);
            if ($attachment_id) {
                $attachment_ids[] = $attachment_id;
            }
        }

        if (!empty($attachment_ids)) {
            // Erstes Bild als Featured Image
            set_post_thumbnail($project_id, $attachment_ids[0]);

            // Galerie-Block in den Content einfuegen
            $gallery = '<p>' . $info['desc'] . '</p>' . "\n\n";
            $gallery .= '<!-- wp:gallery {"linkTo":"none"} -->' . "\n";
            $gallery .= '<figure class="wp-block-gallery has-nested-images columns-default is-cropped">';
            foreach ($attachment_ids as $aid) {
                $img_url = wp_get_attachment_image_url($aid, 'large');
                $gallery .= '<!-- wp:image {"id":' . $aid . ',"sizeSlug":"large"} -->';
                $gallery .= '<figure class="wp-block-image size-large"><img src="' . esc_url($img_url) . '" alt="' . esc_attr($info['title']) . '" class="wp-image-' . $aid . '"/></figure>';
                $gallery .= '<!-- /wp:image -->';
            }
            $gallery .= '</figure>' . "\n";
            $gallery .= '<!-- /wp:gallery -->';

            wp_update_post(array(
                'ID'           => $project_id,
                'post_content' => $gallery,
            ));
        }

        $log[] = "OK: '{$info['title']}' angelegt mit " . count($attachment_ids) . " Bildern.";
    }

    return $log;
}

function bernstorf_import_image($source_path, $parent_id = 0) {
    $upload_dir = wp_upload_dir();
    $filename = basename($source_path);

    // Eindeutigen Dateinamen erzeugen
    $unique = wp_unique_filename($upload_dir['path'], $filename);
    $target = $upload_dir['path'] . '/' . $unique;

    if (!@copy($source_path, $target)) {
        return false;
    }

    $filetype = wp_check_filetype($unique, null);

    $attachment = array(
        'guid'           => $upload_dir['url'] . '/' . $unique,
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace('/\.[^.]+$/', '', $unique),
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    $attach_id = wp_insert_attachment($attachment, $target, $parent_id);
    if (is_wp_error($attach_id) || !$attach_id) {
        return false;
    }

    $attach_data = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return $attach_id;
}

/**
 * Admin-Menue: Importer-Seite
 */
function bernstorf_add_import_menu() {
    add_management_page(
        'Bernstorf Bilder importieren',
        'Bilder importieren',
        'manage_options',
        'bernstorf-import',
        'bernstorf_import_page'
    );
}
add_action('admin_menu', 'bernstorf_add_import_menu');

function bernstorf_import_page() {
    ?>
    <div class="wrap">
        <h1>Projekt-Bilder importieren</h1>
        <?php
        if (isset($_POST['bernstorf_run_import']) && check_admin_referer('bernstorf_import')) {
            echo '<div class="notice notice-info"><p>Import laeuft... bitte warten.</p></div>';
            $log = bernstorf_import_projekte();
            echo '<div class="notice notice-success"><p><strong>Import abgeschlossen!</strong></p>';
            echo '<ul style="list-style:disc;padding-left:20px;">';
            foreach ($log as $line) {
                echo '<li>' . esc_html($line) . '</li>';
            }
            echo '</ul></div>';
        } else {
            ?>
            <p>Importiert die ersten 5 Bilder aus jedem Unterordner von <code>H:/</code> als Projekte mit Galerie.</p>
            <p><strong>Quelle:</strong> H:/&lt;Kategorie&gt;/*.jpg</p>
            <p>Bereits existierende Projekte werden uebersprungen.</p>
            <form method="post" style="margin-top:1.5rem;">
                <?php wp_nonce_field('bernstorf_import'); ?>
                <input type="hidden" name="bernstorf_run_import" value="1">
                <?php submit_button('Import jetzt starten', 'primary'); ?>
            </form>
            <?php
        }
        ?>
    </div>
    <?php
}
