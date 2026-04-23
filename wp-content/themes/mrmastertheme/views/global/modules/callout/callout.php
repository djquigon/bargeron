<?php
    $tag_type = get_sub_field('tag_type');

    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'] ?? '';
    $module_class_names = $unique_identifiers['class_names'] ?? '';

    $closing_tag = '</' . $tag_type . '>';

    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="callout ' . $module_class_names . '">';
    } elseif ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="callout">';
    } elseif (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="callout ' . $module_class_names . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="callout">';
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

    $content = get_sub_field('content');
?>

<?php
    if ($content) :
        echo $opening_tag;
?>
        <div class="container">
            <div class="content" <?= $text_color_attribute ?>>
                <?= $content ?>
            </div>
        </div>
<?php
        echo $closing_tag;
    endif;
?>
