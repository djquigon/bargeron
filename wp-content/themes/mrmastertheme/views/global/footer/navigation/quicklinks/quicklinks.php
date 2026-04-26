<?php
//It's pretty common for a Footer to include a short 'Quicklinks' menu

//We have a dedicated menu location, 'footer_menu', for this widget
?>
<h4>Quick Links</h4>
<?php
if (has_nav_menu('footer_menu')) {
    wp_nav_menu(array(
        'container'       => 'ul',
        'menu_class'      => 'quicklinks',
        'menu_id'         => '',
        'depth'           => 0,
        'theme_location' => 'footer_menu'
    ));
}
?>