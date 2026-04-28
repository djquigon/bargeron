<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');

// Can't just print an empty id and have id="", so build printout here instead
$id = !empty($section_id) ? "id=\"{$section_id}\"" : '';

// Apply padding class
$padding = get_sub_field('padding_between_sections');
$padding_top = $padding['section_padding_top'];
$padding_bottom = $padding['section_padding_bottom'];
if ($padding_top && $padding_bottom) {
    $section_classes .= ' double-padding';
} elseif ($padding_top) {
    $section_classes .= ' double-padding--top';
} elseif ($padding_bottom) {
    $section_classes .= ' double-padding--bot';
}
?>
<section <?= $id; ?> class="section-wrap <?= $section_classes; ?>">
    <div class="full-width">
        <div class="content">
            <?= get_sub_field('content') ?>
        </div>
        <div class="project-cards-wrap">
            <div class="project-cards">
                <?php
                // create taxonomy query to get projects of specific category
                if (str_contains($section_id, "construction-consulting-selector")) {
                    $tax_query = array(
                        array(
                            'taxonomy' => 'project_service',
                            'field' => 'slug',
                            'terms' => 'construction-consulting',
                        )
                    );
                } elseif (str_contains($section_id, "construction-management-selector")) {
                    $tax_query = array(
                        array(
                            'taxonomy' => 'project_service',
                            'field' => 'slug',
                            'terms' => 'construction-management',
                        )
                    );
                } elseif (str_contains($section_id, "design-build-selector")) {
                    $tax_query = array(
                        array(
                            'taxonomy' => 'project_service',
                            'field' => 'slug',
                            'terms' => 'design-build',
                        )
                    );
                } elseif (str_contains($section_id, "general-contractor-selector")) {
                    $tax_query = array(
                        array(
                            'taxonomy' => 'project_service',
                            'field' => 'slug',
                            'terms' => 'general-contractor',
                        )
                    );
                } elseif (str_contains($section_id, "historic-preservation-selector")) {
                    $tax_query = array(
                        array(
                            'taxonomy' => 'project_industry',
                            'field' => 'slug',
                            'terms' => 'historic-preservation',
                        )
                    );
                } else {
                    $tax_query = null;
                }
                $args = array(
                    'post_type' => 'mandr_project',
                    'post_status' => 'publish',
                    'posts_per_page' => 4,
                    'tax_query' => $tax_query,
                );
                $loop = new WP_Query($args);
                if ($loop->found_posts < 4) {
                    $args = array(
                        'post_type' => 'mandr_project',
                        'post_status' => 'publish',
                        'posts_per_page' => 4,
                    );
                    $loop = new WP_Query($args);
                }
                while ($loop->have_posts()) : $loop->the_post();
                    $featured_img_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');
                    $title = get_the_title();
                    $link = get_the_permalink();
                ?>
                    <div class="project-cards__card" style="background-image: url(<?= $featured_img_url ?>)">
                        <span class="project-cards__card__overlay"></span>
                        <div class="project-cards__card__content">
                            <h3 class="project-cards__card__title">
                                <?= $title ?>
                            </h3>
                            <a class="project-cards__card__link" href="<?= $link ?>">
                                <span class="link-spanner"></span>
                                <span>VIEW PROJECT</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="50.343" height="13.595" viewBox="0 0 50.343 13.595">
                                    <g data-name="Group 35" transform="translate(-207.5 -1959.146)">
                                        <line data-name="Line 42" x2="49" transform="translate(207.5 1966.5)" fill="none" stroke="#F5F5F5" stroke-width="1" />
                                        <path data-name="Path 345" d="M6793.8,2367c2.207,2.207,6.837,6.813,6.837,6.813l-6.837,6.053" transform="translate(-6543.525 -407.5)" fill="none" stroke="#F5F5F5" stroke-width="1" />
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <a class="btn" role="button" href="/our-work/">View All Work</a>
        </div>
    </div>
</section>