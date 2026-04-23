<?php
    $tag_type = get_sub_field('tag_type');
    $layout = get_sub_field('layout');
    $container_width = get_sub_field('container_width');

    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'] ?? '';
    $module_class_names = $unique_identifiers['class_names'] ?? '';

    $closing_tag = '</' . $tag_type . '>';

    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="toggles ' . $module_class_names . '" data-layout="' . $layout . '">';
    } elseif ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="toggles" data-layout="' . $layout . '">';
    } elseif (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="toggles ' . $module_class_names . '" data-layout="' . $layout . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="toggles" data-layout="' . $layout . '">';
    }

    $padding_settings = get_sub_field('padding');
    $top_padding_desktop = $padding_settings['top_padding_desktop'] ?? '';
    $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'] ?? '';
    $top_padding_mobile = $padding_settings['top_padding_mobile'] ?? '';
    $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'] ?? '';

    $padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

    $background_settings = get_sub_field('background');
    $background_type = $background_settings['background_type'] ?? 'transparent';

    if ($background_type === 'color') {
        $background_color = $background_settings['background_color'] ?? '';
        $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } elseif ($background_type === 'image') {
        $background_image = $background_settings['background_image'] ?? null;
        $background_image_url = $background_image['url'] ?? '';
        $background_image_position = $background_settings['background_image_position'] ?? 'center';

        if (!empty($background_settings['include_overlay'])) {
            $background_image_overlay = $background_settings['overlay_color'] ?? '';
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        }
    } else {
        $background_settings_tag = '';
    }

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

    $intro_content = get_sub_field('intro_content');
    $toggles = get_sub_field('toggles');
?>

<?php
    if ($toggles) :
        echo $opening_tag;
?>
        <?php if ($intro_content) : ?>
            <div class="intro-content-row">
                <div class="container" <?= $text_color_attribute ?>>
                    <?= $intro_content ?>
                    <span
                        class="container-settings"
                        data-container-width="<?= $container_width ?>">
                        <span class="validator-text" data-nosnippet>settings</span>
                    </span>
                </div>
            </div>
        <?php endif; ?>
        <div class="toggles-row">
            <div class="container" <?= $text_color_attribute ?>>
                <dl class="toggles-list">
                    <?php
                    $random_integer = rand(0, 999);
                    $toggle_count = 0;
                    foreach ($toggles as $row) {
                        $title = $row['title'] ?? '';
                        $content = $row['content'] ?? '';
                        $image = $row['image'] ?? null;
                        $aria_controls_value = 'toggle-' . $random_integer . '-' . $toggle_count;

                        $answer = $content;
                        if (!empty($image['url'])) {
                            $answer .= '<figure class="toggle-image"><img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? '') . '" loading="lazy" decoding="async" /></figure>';
                        }

                        $template_args = array(
                            'question' => $title,
                            'answer' => $answer,
                            'aria_controls_value' => $aria_controls_value,
                        );

                        get_template_part('views/global/widgets/toggles/toggle', null, $template_args);
                        $toggle_count++;
                    }
                    ?>
                </dl>
                <span
                    class="container-settings"
                    data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
        <span class="module-settings" data-nosnippet>
            <?= $padding_settings_tag ?>
            <?= $background_settings_tag ?>
            <span class="validator-text">module settings</span>
        </span>
<?php
        echo $closing_tag;
    endif;
?>
