<?php
    $location_id  = get_the_ID();
    $location_info = get_field('location_info');

    if (!$location_info) return;

    $geolocation         = $location_info['geolocation'];
    $contact_information = $location_info['contact_information'];

    $org_names = get_field('schema_names', 'options');
    $org_name  = $org_names['name'] ?? get_bloginfo('name');

    $schema = [
        '@context'           => 'https://schema.org',
        '@type'              => 'LocalBusiness',
        'name'               => get_the_title(),
        'url'                => get_permalink(),
        'parentOrganization' => [
            '@type' => 'Organization',
            'name'  => $org_name,
        ],
    ];

    if (!empty($geolocation['address'])) {
        $schema['address'] = [
            '@type'         => 'PostalAddress',
            'streetAddress' => $geolocation['address'],
        ];
    }

    $phone = $contact_information['phone'] ?? null;
    if ($phone) {
        $schema['telephone'] = $phone;
    }

    $email = $contact_information['email'] ?? null;
    if ($email) {
        $schema['email'] = $email;
    }

    $website_url = $contact_information['website_url'] ?? null;
    if ($website_url) {
        $website_url = str_replace('http://', '', $website_url);
        if (!str_contains($website_url, 'https://')) {
            $website_url = 'https://' . $website_url;
        }
        $schema['sameAs'] = $website_url;
    }

    $image = get_the_post_thumbnail_url($location_id, 'full');
    if ($image) {
        $schema['image'] = $image;
    }
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
