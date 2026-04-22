<?php
    $post_id     = get_the_ID();
    $author_id   = get_post_field('post_author', $post_id);
    $author_name = get_field('post_author_name', 'user_' . $author_id)
                   ?: get_the_author_meta('display_name', $author_id);

    $org_names      = get_field('schema_names', 'options');
    $publisher_name = $org_names['name'] ?? get_bloginfo('name');
    $logo           = get_field('schema_logo', 'options');

    $title_area = get_field('title_area');
    $headline   = ($title_area && !empty($title_area['page_title']))
                  ? $title_area['page_title']
                  : get_the_title();

    $schema = [
        '@context'         => 'https://schema.org',
        '@type'            => 'BlogPosting',
        'headline'         => $headline,
        'url'              => get_permalink(),
        'datePublished'    => get_the_date('c'),
        'dateModified'     => get_the_modified_date('c'),
        'author'           => [
            '@type' => 'Person',
            'name'  => $author_name,
        ],
        'publisher'        => [
            '@type' => 'Organization',
            'name'  => $publisher_name,
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => get_permalink(),
        ],
    ];

    $featured_image = get_the_post_thumbnail_url($post_id, 'full');
    $fallback_image = $logo ? $logo['url'] : null;
    $schema['image'] = $featured_image ?: $fallback_image;

    $excerpt = wp_strip_all_tags(get_the_excerpt($post_id));
    if ($excerpt) {
        $schema['description'] = $excerpt;
    }

    if ($logo) {
        $schema['publisher']['logo'] = [
            '@type' => 'ImageObject',
            'url'   => $logo['url'],
        ];
    }
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
