<?php
if (have_rows('modules')) :
    $shared_background_is_open = false;

    while (have_rows('modules')) :
        the_row();

        if (get_row_layout() == 'background_start') :
            if ($shared_background_is_open) :
                get_template_part('views/global/modules/shared-background/background-end');
            endif;
            get_template_part('views/global/modules/shared-background/background-start');
            $shared_background_is_open = true;

        elseif (get_row_layout() == 'background_end') :
            if ($shared_background_is_open) :
                get_template_part('views/global/modules/shared-background/background-end');
                $shared_background_is_open = false;
            endif;

        elseif (get_row_layout() == 'standard_content') :
            get_template_part('views/global/modules/standard-content/standard-content');

        elseif (get_row_layout() == 'callout') :
            get_template_part('views/global/modules/callout/callout');

        elseif (get_row_layout() == 'content_two_images') :
            get_template_part('views/global/modules/content-two-images/content-two-images');

        elseif (get_row_layout() == 'toggles') :
            get_template_part('views/global/modules/toggles/toggles');

        elseif (get_row_layout() == 'testimonials') :
            get_template_part('views/global/modules/testimonials/testimonials');

        elseif (get_row_layout() == 'three_link_columns') :
            get_template_part('views/global/modules/three-link-columns/three-link-columns');

        endif;
    endwhile;

    if ($shared_background_is_open) :
        get_template_part('views/global/modules/shared-background/background-end');
    endif;
endif;
