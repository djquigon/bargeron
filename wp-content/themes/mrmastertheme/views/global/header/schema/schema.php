<?php
    //Organization — front page only, and optionally a dedicated About page set in ACF Options
    $schema_about_page_id = get_field('schema_about_page', 'options');
    if (is_front_page() || ($schema_about_page_id && is_page($schema_about_page_id))) {
        echo get_template_part('views/conditional/pages/front-page/schema/organization');
    }

    //AboutPage — dedicated About page set in ACF Options (reuses $schema_about_page_id from above)
    if ($schema_about_page_id && is_page($schema_about_page_id)) {
        echo get_template_part('views/conditional/pages/about-page/schema/about-page');
    }

    //ContactPage — any page whose slug contains 'contact'
    if (is_page() && str_contains(get_post_field('post_name', get_queried_object_id()), 'contact')) {
        echo get_template_part('views/conditional/pages/contact-page/schema/contact-page');
    }

    //BlogPosting — single blog posts
    if (is_singular('post')) {
        echo get_template_part('views/conditional/posts/single/schema/blog-posting');
    }

    //FAQPage — dedicated FAQs archive page (module-based pages output schema inline from faqs.php)
    if (is_page('faqs-archive')) {
        echo get_template_part('views/conditional/pages/FAQs-page/schema/faq-page');
    }

    //Person — single team member pages
    if (is_singular('mandr_team_member')) {
        echo get_template_part('views/conditional/team/single/schema/person');
    }

    //LocalBusiness — single location pages
    if (is_singular('mandr_location')) {
        echo get_template_part('views/conditional/locations/single/schema/local-business');
    }

    //CollectionPage — blog, project, and team archive pages
    if (is_home()) {
        echo get_template_part('views/conditional/posts/archive/schema/collection-page');
    }
    if (is_post_type_archive('mandr_project')) {
        echo get_template_part('views/conditional/projects/archive/schema/collection-page');
    }
    if (is_post_type_archive('mandr_team_member')) {
        echo get_template_part('views/conditional/team/archive/schema/collection-page');
    }

    //CollectionPage — gallery archive
    if (is_post_type_archive('mandr_gallery')) {
        echo get_template_part('views/conditional/galleries/archive/schema/media-gallery');
    }

    //MediaGallery — single gallery pages (inline ItemList also output from media-gallery module)
    if (is_singular('mandr_gallery')) {
        echo get_template_part('views/conditional/galleries/single/schema/media-gallery');
    }

    //CollectionPage + ItemList — locations archive (routed via is_page, not a traditional CPT archive)
    if (is_page('locations')) {
        echo get_template_part('views/conditional/pages/locations-page/schema/collection-page');
    }
