<?php
    $faqs = get_posts([
        'post_type'      => 'mandr_faq',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    if (!$faqs) return;

    $schema = [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => [],
    ];

    foreach ($faqs as $faq) {
        $question = get_the_title($faq);
        $answer   = wp_strip_all_tags(get_the_content(null, false, $faq));

        if ($question && $answer) {
            $schema['mainEntity'][] = [
                '@type'          => 'Question',
                'name'           => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $answer,
                ],
            ];
        }
    }

    if (empty($schema['mainEntity'])) return;
?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
