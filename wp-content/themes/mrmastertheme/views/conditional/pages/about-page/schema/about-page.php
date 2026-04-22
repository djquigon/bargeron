<?php
    $org_names = get_field('schema_names', 'options');
    $org_name  = $org_names['name'] ?? get_bloginfo('name');

    $schema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'AboutPage',
        'name'      => get_the_title(),
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
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
