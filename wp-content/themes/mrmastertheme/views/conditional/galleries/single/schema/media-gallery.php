<?php
    $org_names = get_field('schema_names', 'options');
    $org_name  = $org_names['name'] ?? get_bloginfo('name');

    $title_area = get_field('title_area');
    $name       = ($title_area && !empty($title_area['page_title']))
                  ? $title_area['page_title']
                  : get_the_title();

    $schema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'MediaGallery',
        'name'      => $name,
        'url'       => get_permalink(),
        'publisher' => [
            '@type' => 'Organization',
            'name'  => $org_name,
        ],
    ];

    $excerpt = wp_strip_all_tags(get_the_excerpt());
    if ($excerpt) {
        $schema['description'] = $excerpt;
    }

    $thumbnail = get_the_post_thumbnail_url(null, 'full');
    if ($thumbnail) {
        $schema['image'] = $thumbnail;
    }
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
