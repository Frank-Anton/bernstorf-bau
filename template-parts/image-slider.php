<?php
/**
 * Image Slider Template Part
 *
 * Erwartet: $slider_images = array von ['src', 'alt', 'title']
 */
if (empty($slider_images) || !is_array($slider_images)) {
    return;
}
$slider_id = 'slider-' . wp_unique_id();
?>
<div class="image-slider" data-slider>
    <button class="image-slider__btn image-slider__btn--prev" data-slider-prev aria-label="Vorheriges Bild">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6z"/></svg>
    </button>

    <div class="image-slider__track" data-slider-track>
        <?php foreach ($slider_images as $img) : ?>
            <div class="image-slider__slide">
                <img src="<?php echo esc_url($img['src']); ?>"
                     alt="<?php echo esc_attr($img['alt']); ?>"
                     loading="lazy">
                <?php if (!empty($img['title'])) : ?>
                    <span class="image-slider__caption"><?php echo esc_html($img['title']); ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <button class="image-slider__btn image-slider__btn--next" data-slider-next aria-label="Naechstes Bild">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
    </button>
</div>
