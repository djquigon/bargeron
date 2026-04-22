<?php
    $blog_page_id = get_option('page_for_posts');

    $org_names = get_field('schema_names', 'options');
    $org_name  = $org_names['name'] ?? get_bloginfo('name');

    $schema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'CollectionPage',
        'name'      => $blog_page_id ? get_the_title($blog_page_id) : get_bloginfo('name') . ' — Blog',
        'url'       => $blog_page_id ? get_permalink($blog_page_id) : get_bloginfo('url'),
        'publisher' => [
            '@type' => 'Organization',
            'name'  => $org_name,
        ],
    ];

    if ($blog_page_id) {
        $excerpt = wp_strip_all_tags(get_the_excerpt($blog_page_id));
        if ($excerpt) {
            $schema['description'] = $excerpt;
        }
    }
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
