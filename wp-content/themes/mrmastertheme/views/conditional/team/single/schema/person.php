<?php
    $member_id  = get_the_ID();
    $first_name = get_field('first_name', $member_id);
    $last_name  = get_field('last_name', $member_id);

    if (!$first_name || !$last_name) return;

    $org_names = get_field('schema_names', 'options');
    $org_name  = $org_names['name'] ?? get_bloginfo('name');

    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Person',
        'name'     => $first_name . ' ' . $last_name,
        'url'      => get_permalink(),
        'worksFor' => [
            '@type' => 'Organization',
            'name'  => $org_name,
        ],
    ];

    $position = get_field('position', $member_id);
    if ($position) {
        $schema['jobTitle'] = $position;
    }

    $email = get_field('email', $member_id);
    if ($email) {
        $schema['email'] = $email;
    }

    $phone = get_field('phone_number', $member_id);
    if ($phone) {
        $schema['telephone'] = $phone;
    }

    $bio = get_field('bio', $member_id);
    if ($bio) {
        $schema['description'] = wp_strip_all_tags($bio);
    }

    $image = get_the_post_thumbnail_url($member_id, 'full');
    if ($image) {
        $schema['image'] = $image;
    }
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
