<?php

    function bulledart_supports()
    {
        //Support title
        add_theme_support('title-tag');
    }

    function bulledart_register_assets()
    {
        wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
        wp_register_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', [], false, true);
        wp_enqueue_style('bootstrap');
        wp_enqueue_script('bootstrap');
    }

    //Hook support du titre
    add_action('after_setup_theme', 'bulledart_supports');

    //Hook Ajout du style
    add_action('wp_enqueue_scripts', 'bulledart_register_assets');