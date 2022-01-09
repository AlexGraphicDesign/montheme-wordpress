<?php
//https://developer.wordpress.org/reference/hooks/customize_register/
//https://developer.wordpress.org/reference/classes/wp_customize_manager/
add_action('customize_register', function(WP_Customize_Manager $manager){

    $manager->add_section('bulledart_apparence', [
        'title' => 'Personnalisation de l\'apparence',

    ]);

    $manager->add_setting('header_background', [
        'default' => '#FF0000',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color'
    ]);

    //Méthode 1
    // $manager->add_control('header_background', [
    //     'section' => 'bulledart_apparence',
    //     'setting' => 'header_background',
    //     'label' => 'Couleur de l\'en-tête'
    // ]);

    //Méthode 2
    $manager->add_control(new WP_Customize_Color_Control($manager, 'header_background', [
        'section' => 'bulledart_apparence',
        'label' => 'Couleur de l\'en-tête'
    ]));
});

add_action('customize_preview_init', function(){
    wp_enqueue_script('bulledart_apparence', get_template_directory_uri() . '/assets/apparence.js', ['jquery', 'customize-preview'], '', true);
});