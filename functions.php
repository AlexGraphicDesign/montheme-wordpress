<?php

    function bulledart_supports()
    {
        //Support title
        add_theme_support('title-tag');
        //Support image mise en avant
        add_theme_support('post-thumbnails');
        //Support Menu
        add_theme_support('menus');
        register_nav_menu('header', 'En-tête du menu');
        register_nav_menu('footer', 'Pied de page');

        add_image_size('card-header', 350, 215, true);
        // remove_image_size('medium');
        // add_image_size('medium', 500, 500);
    }

    function bulledart_register_assets()
    {
        wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
        wp_register_script('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', [], false, true);
        wp_enqueue_style('bootstrap');
        wp_enqueue_script('bootstrap');
    }

    function bulledart_title_separator()
    {
        return '|';
    }

    function bulledart_menu_class($classes)
    {
        $classes[] = 'nav-item';
        return $classes;
    }

    function bulledart_link_class($attrs)
    {
        $attrs['class'] = 'nav-link';
        return $attrs;
    }

    function bulledart_pagination()
    {
        $pages = paginate_links(['type' => 'array']);
        if($pages === null)
        {
            return;
        }
        echo '<nav aria-label="Pagination" class="my-4">';
            echo '<ul class="pagination">';
                foreach ($pages as $page){
                    $active = strpos($page, 'current') !== false;
                    $class = "page-item";
                    if ($active)
                    {
                        $class .= " active";
                    }
                    echo '<li class="'.$class.'">';
                    echo str_replace('page-numbers', 'page-link', $page);
                    echo '</li>';
                }
            echo '</ul>';
        echo '</nav>';
    }

    function bulledart_init()
    {
        register_taxonomy('sport', 'post', [
            'labels' => [
                'name' => 'Sport',
                'singular_name'     => 'Sport',
                'plural_name'       => 'Sports',
                'search_items'      => 'Rechercher des sports',
                'all_items'         => 'Tous les sports',
                'edit_item'         => 'Editer le sport',
                'update_item'       => 'Mettre à jour le sport',
                'add_new_item'      => 'Ajouter un nouveau sport',
                'new_item_name'     => 'Ajouter un nouveau sport',
                'menu_name'         => 'Sport',
            ],
            'show_in_rest' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
        ]);

        register_post_type('bien', [
            'label' => 'Bien',
            'public' => true,
            'menu_position' => 3,
            'menu_icon' => 'dashicons-building',
            'supports' => ['title', 'editor', 'thumbnail'],
            'show_in_rest' => true,
            'has_archive' => true
        ]);
    }

    add_action('init', 'bulledart_init');

    //Hook support du titre
    add_action('after_setup_theme', 'bulledart_supports');

    //Hook Ajout du style
    add_action('wp_enqueue_scripts', 'bulledart_register_assets');

    //Hook Modification du séparateur de titre
    add_filter('document_title_separator', 'bulledart_title_separator');

    //On modifie le menu principal
    add_filter('nav_menu_css_class', 'bulledart_menu_class');
    add_filter('nav_menu_link_attributes', 'bulledart_link_class');

    require_once('classes/metaboxes/sponso.php');
    require_once('classes/options/agence.php');
    
    SponsoMetaBox::register();
    AgenceMenuPage::register();