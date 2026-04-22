<?php
    $unique_identifiers = get_sub_field('unique_identifiers');
    $background_settings = get_sub_field('background');

    $module_id = $unique_identifiers['id'] ?? '';
    $module_class_names = $unique_identifiers['class_names'] ?? '';

    if ($module_id && $module_class_names) {
        $opening_tag = '<div id="' . $module_id . '" class="shared-background ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<div id="' . $module_id . '" class="shared-background">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<div class="shared-background ' . $module_class_names . '">';
    } else {
        $opening_tag = '<div class="shared-background">';
    }

    $background_type = $background_settings['background_type'] ?? 'transparent';

    if ($background_type === 'color') {
        $background_color = $background_settings['background_color'] ?? '';
        $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else if ($background_type === 'image') {
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

    echo $opening_tag;
?>
<span class="module-settings" data-nosnippet>
    <?= $background_settings_tag ?>
    <span class="validator-text">module settings</span>
</span>
