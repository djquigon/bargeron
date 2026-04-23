<?php
    echo get_template_part('views/global/title-area/title-area');

    //if we're using a title-area specific to the gallery post type:
    //echo get_template_part('views/conditional/galleries/single/title-area/title-area');

    //If there are images/video in the gallery, then display that module:
    if (get_field('media_gallery')) {
        echo get_template_part('views/global/components/media-gallery/media-gallery', null, array('media_gallery' => get_field('media_gallery'), 'layout' => 'masonry'));
    }

    //spit out all the individual page sections (modules)
    echo get_template_part('views/global/modules/modules'); 

    //close out the page with post navigation:
    echo get_template_part('views/global/widgets/single-post-navigation/single-post-navigation');
?> 