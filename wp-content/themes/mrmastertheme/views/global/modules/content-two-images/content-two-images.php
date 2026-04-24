<?php
$tag_type = get_sub_field('tag_type');
$layout = get_sub_field('layout');

$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'] ?? '';
$module_class_names = $unique_identifiers['class_names'] ?? '';

$closing_tag = '</' . $tag_type . '>';

if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="content-two-images ' . $module_class_names . '" data-layout="' . $layout . '">';
} elseif ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="content-two-images" data-layout="' . $layout . '">';
} elseif (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="content-two-images ' . $module_class_names . '" data-layout="' . $layout . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="content-two-images" data-layout="' . $layout . '">';
}

$module_background_settings = get_sub_field('module_background');
$module_background_type = $module_background_settings['background_type'] ?? 'transparent';

if ($module_background_type === 'color') {
    $module_background_color = $module_background_settings['background_color'] ?? '';
    $module_background_settings_tag = '<span class="background" style="background-color:' . $module_background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
} elseif ($module_background_type === 'image') {
    $module_background_image = $module_background_settings['background_image'] ?? null;
    $module_background_image_url = $module_background_image['url'] ?? '';
    $module_background_image_position = $module_background_settings['background_image_position'] ?? 'center';

    if (!empty($module_background_settings['include_overlay'])) {
        $module_background_image_overlay = $module_background_settings['overlay_color'] ?? '';
        $module_background_settings_tag = '<span class="background" style="background-image:url(' . $module_background_image_url . '); --overlay-color:' . $module_background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $module_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else {
        $module_background_settings_tag = '<span class="background" style="background-image:url(' . $module_background_image_url . ')" data-background-image-position="' . $module_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    }
} else {
    $module_background_settings_tag = '';
}

$module_padding_settings = get_sub_field('module_padding');
$module_top_padding_desktop = $module_padding_settings['top_padding_desktop'] ?? '';
$module_bottom_padding_desktop = $module_padding_settings['bottom_padding_desktop'] ?? '';
$module_top_padding_mobile = $module_padding_settings['top_padding_mobile'] ?? '';
$module_bottom_padding_mobile = $module_padding_settings['bottom_padding_mobile'] ?? '';

$module_padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $module_top_padding_desktop . '" data-bottom-padding-desktop="' . $module_bottom_padding_desktop . '" data-top-padding-mobile="' . $module_top_padding_mobile . '" data-bottom-padding-mobile="' . $module_bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

$text_color_settings = get_sub_field('text_color');

if (!empty($text_color_settings['headings_color']) || !empty($text_color_settings['body_text_color']) || !empty($text_color_settings['link_color']) || !empty($text_color_settings['link_hover_color'])) {
    $text_color_attribute = 'style="';

    if (!empty($text_color_settings['headings_color'])) {
        $text_color_attribute .= '--headings-color:' . $text_color_settings['headings_color'] . ';';
    }

    if (!empty($text_color_settings['body_text_color'])) {
        $text_color_attribute .= '--body-text-color:' . $text_color_settings['body_text_color'] . ';';
    }

    if (!empty($text_color_settings['link_color'])) {
        $text_color_attribute .= '--link-color:' . $text_color_settings['link_color'] . ';';
    }

    if (!empty($text_color_settings['link_hover_color'])) {
        $text_color_attribute .= '--link-hover-color:' . $text_color_settings['link_hover_color'] . ';';
    }

    $text_color_attribute .= '"';
} else {
    $text_color_attribute = '';
}

$sub_heading = get_sub_field('sub-heading');
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$large_image = get_sub_field('large_image');
$small_image = get_sub_field('small_image');

$has_text = $sub_heading || $heading || $content;
$has_images = !empty($large_image['url']) || !empty($small_image['url']);
?>

<?php
if ($has_text || $has_images) :
    echo $opening_tag;
?>
    <div class="container">
        <div class="text-column" <?= $text_color_attribute ?>>
            <?php if ($sub_heading) : ?>
                <h6 class="sub-heading"><?= esc_html($sub_heading) ?></h6>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h2 class="heading"><?= esc_html($heading) ?></h2>
            <?php endif; ?>
            <?php if ($content) : ?>
                <div class="content">
                    <?= $content ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="images-column">
            <?php if (!empty($large_image['url'])) : ?>
                <div class="image image--large">
                    <img src="<?= esc_url($large_image['url']) ?>" alt="<?= esc_attr($large_image['alt'] ?? '') ?>" width="<?= esc_attr($large_image['width'] ?? '') ?>" height="<?= esc_attr($large_image['height'] ?? '') ?>" loading="lazy" decoding="async" />
                </div>
            <?php endif; ?>
            <?php if (!empty($small_image['url'])) : ?>
                <div class="image image--small">
                    <img src="<?= esc_url($small_image['url']) ?>" alt="<?= esc_attr($small_image['alt'] ?? '') ?>" width="<?= esc_attr($small_image['width'] ?? '') ?>" height="<?= esc_attr($small_image['height'] ?? '') ?>" loading="lazy" decoding="async" />
                </div>
            <?php endif; ?>
        </div>
        <span class="container-settings" data-container-width="wide">
            <span class="validator-text" data-nosnippet>container settings</span>
        </span>
    </div>
    <span class="module-settings" data-nosnippet>
        <?= $module_padding_settings_tag ?>
        <?= $module_background_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>