<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/logo.svg'); ?>" alt="<?php bloginfo('name'); ?>" class="footer-logo">
                <p>Ob Neubau, Umbau oder Sanierung &ndash; wir bieten Ihnen professionelle L&ouml;sungen aus einer Hand.</p>
            </div>

            <div class="footer-col">
                <h4>Leistungen</h4>
                <ul>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('leistungen'))); ?>">Maurerarbeiten</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('leistungen'))); ?>">Putzarbeiten</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('leistungen'))); ?>">Sanierung</a></li>
                    <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('leistungen'))); ?>">Neubau</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Navigation</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'items_wrap'     => '<ul>%3$s</ul>',
                    'depth'          => 1,
                    'fallback_cb'    => false,
                ));
                ?>
            </div>

            <div class="footer-col">
                <h4>Kontakt</h4>
                <?php
                $phone   = get_theme_mod('bernstorf_phone', '');
                $email   = get_theme_mod('bernstorf_email', '');
                $address = get_theme_mod('bernstorf_address', '');
                $city    = get_theme_mod('bernstorf_city', '');
                ?>
                <?php if ($phone) : ?>
                    <p><?php echo bernstorf_icon('phone'); ?> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                <?php endif; ?>
                <?php if ($email) : ?>
                    <p><?php echo bernstorf_icon('mail'); ?> <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                <?php endif; ?>
                <?php if ($address) : ?>
                    <p><?php echo esc_html($address); ?><?php if ($city) echo '<br>' . esc_html($city); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Alle Rechte vorbehalten. | <a href="<?php echo esc_url(get_permalink(get_page_by_path('impressum'))); ?>">Impressum</a> | <a href="<?php echo esc_url(get_permalink(get_page_by_path('datenschutz'))); ?>">Datenschutz</a></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
