<?php
$module_title = $args['module_title'];
$include_intro_content = $args['include_intro_content'];
$intro_content = $args['intro_content'];
$testimonials = $args['testimonials'];
$text_color_attribute = $args['text_color_attribute'];
$random_integer = wp_rand(1000, 9999);
$testimonial_count = count($testimonials);

if ($module_title || ($include_intro_content && $intro_content)) :
?>
    <div class="intro-content-row">
        <div class="container" <?= $text_color_attribute ?>>
            <?php
            if ($module_title) {
                echo '<h2>' . $module_title . '</h2>';
            }
            ?>
            <?php
            if ($include_intro_content && $intro_content) {
                echo $intro_content;
            }
            ?>
            <span
                class="container-settings"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </div>
<?php
endif;
?>
<div class="testimonials-row">
    <div
        id="testimonials-slider-<?= $random_integer ?>"
        class="columns testimonials-slider">
        <?php
        foreach ($testimonials as $testimonial) :
            $testimonial_content = $testimonial['testimonial'];
            $testimonial_author_name = $testimonial['author_name'];
            $testimonial_author_title = $testimonial['author_title'];
        ?>
            <div class="testimonial column" <?= $text_color_attribute ?>>
                <div class="content">
                    <?= $testimonial_content ?>
                </div>
                <div class="author">
                    <span class="name"><?= $testimonial_author_name ?></span>
                    <?php
                    if ($testimonial_author_title) :
                    ?>
                        <span class="title"><?= $testimonial_author_title ?></span>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <?php
    if ($testimonial_count > 2) :
    ?>
        <div id="append-arrows-<?= $random_integer ?>" class="container testimonials-slider-arrows">
            <span
                class="container-settings"
                data-container-width="standard"
                data-arrows-position="right">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <span class="slider-settings">
            <script>
                jQuery(function($) {
                    $('#testimonials-slider-<?= $random_integer ?>').not('.slick-initialized').slick({
                        appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                        arrows: true,
                        dots: false,
                        infinite: true,
                        speed: 500,
                        rows: 0,
                        centerMode: false,
                        slide: '.testimonial',
                        slidesToScroll: 1,
                        slidesToShow: 3,
                        responsive: [{
                                breakpoint: 1024,
                                settings: {
                                    arrows: false,
                                    slidesToShow: 2
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1
                                }
                            }
                        ]
                    });
                });
            </script>
            <span class="validator-text" data-nosnippet>slider settings</span>
        </span>
    <?php
    endif;
    ?>
    <span
        class="row-settings"
        data-container-width="standard">
        <span class="validator-text" data-nosnippet>settings</span>
    </span>
</div>