<?php
    $org_names = get_field('schema_names', 'options');
    $org_name  = $org_names['name'] ?? get_bloginfo('name');

    $schema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'CollectionPage',
        'name'      => post_type_archive_title('', false),
        'url'       => get_post_type_archive_link('mandr_team_member'),
        'publisher' => [
            '@type' => 'Organization',
            'name'  => $org_name,
        ],
    ];
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
