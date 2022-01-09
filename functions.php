<?php

    require_once('walker/CommentWalker.php');
    require_once('classes/options/apparence.php');
    require_once('classes/options/cron.php');

    function bulledart_supports()
    {
        //Support title
        add_theme_support('title-tag');
        //Support image mise en avant
        add_theme_support('post-thumbnails');
        //Support Menu
        add_theme_support('menus');
        add_theme_support('html5');
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
        wp_register_style('front', get_template_directory_uri() . '/assets/front.css', ['bootstrap'], false);

        // if (!is_customize_preview()) {
        //     wp_deregister_script('jquery');
        //     wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', [], false, true);
        // }

        wp_enqueue_style('bootstrap');
        wp_enqueue_style('front');
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

        // add_action('init', function(){
        //     register_post_type('bien', [
        //         'label' => 'Bien',
        //         'public' => true,
        //         'menu_position' => 3,
        //         'menu_icon' => 'dashicons-building',
        //         'supports' => ['title', 'editor', 'thumbnail'],
        //         'show_in_rest' => true,
        //         'has_archive' => true
        //     ]);
        // });
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

    //On modifie le tableu des Biens
    add_filter('manage_bien_posts_columns', function($columns) {
        return [
            'cb' => $columns['cb'],
            'thumbnail' => 'Miniature',
            'title' => $columns['title'],
            'date' => $columns['date']
        ];
    });

    add_filter('manage_bien_posts_custom_column', function ($column, $postId){
        if($column === 'thumbnail'){
            the_post_thumbnail('thumbnail', $postId);
        } 
    }, 10, 2);

    add_action('admin_enqueue_scripts', function(){
        wp_enqueue_style('admin_bulledart', get_template_directory_uri() . './assets/admin.css');
    });

    //On modifie le tableau des posts
    add_filter('manage_post_posts_columns', function($columns) {
        $newColumns = [];
        foreach($columns as $k => $v){
            if($k === 'date'){
                $newColumns['sponso'] = 'Article Sponsorisé';
            }
            $newColumns[$k] = $v;
        }
        return $newColumns;
    });

    add_filter('manage_post_posts_custom_column', function ($column, $postId){
        if($column === 'sponso'){
            if(!empty(get_post_meta($postId, SponsoMetaBox::META_KEY, true))){
                $class = 'yes';
            } else {
                $class = 'no';
            }

            echo "<div class='bullet bullet-".$class."'></div>";
        } 
    }, 10, 2);

    function bulledart_pre_get_posts(WP_Query $query){
        if(is_admin() || !is_search() || !$query->is_main_query()){
            return;
        }
        if(get_query_var('sponso') === '1'){
            $meta_query = $query->get('meta_query', []);
            $meta_query[] = [
                'key' => SponsoMetaBox::META_KEY,
                'compare' => 'EXISTS'
            ];
        }
        $query->set('meta_query', $meta_query);
    }

    function bulledart_query_vars($params){
        $params[] = 'sponso';
        return $params;
    }

    add_action('pre_get_posts', 'bulledart_pre_get_posts');
    add_filter('query_vars', 'bulledart_query_vars');

    require_once('classes/widgets/YoutubeWidget.php');

    function bulledart_register_widget(){
        register_widget(YoutubeWidget::class);
        register_sidebar([
            'id' => 'homepage',
            'name' => __('Sidebar Accueil', 'bulledart'),
            'before_widget' => '<div class="p-4 %2$s" id="%1$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="fst-italic">',
            'after_title' => '</h4>',
        ]);
    }

    add_action('widgets_init', 'bulledart_register_widget');

    add_filter('comment_form_default_fields', function ($fields){
        $fields['email'] = <<<HTML
        <div class="form-group">
            <label for="email">Votre mail</label>
            <input type="text" class="form-control" name="email" id="email" required="required">
        </div>
        HTML;
        return $fields;
    });

    add_action('after_switch_theme', 'flush_rewrite_rules');
    add_action('switch_theme', 'flush_rewrite_rules');

    //https://developer.wordpress.org/themes/functionality/internationalization/
    //https://developer.wordpress.org/apis/handbook/internationalization/
    add_action('after_setup_theme', function(){
        load_theme_textdomain('bulledart', get_template_directory() . '/languages');
    });

    /** @var wpdb $wpdb */
    global $wpdb;
    //var_dump($wpdb->terms);

    $tag = "football";
    $query = $wpdb->prepare("SELECT name FROM {$wpdb->terms} WHERE slug=%s", [$tag]);
    $results = $wpdb->get_results($query);

    add_filter('rest_authentication_errors', function( $result ) {
        if ( true === $result || is_wp_error( $result ) ) {
            return $result;
        }

        /** @var WP $wp */
        global $wp;
        if(strpos($wp->query_vars['rest_route'], 'montheme/v1') !== false){
            return true;
        }
        return $result;
    }, 9);

    //api : https://developer.wordpress.org/rest-api/
    // pour tester : http://bulle-d-art.test/wp-json/montheme/v1/demo/41
    add_action('rest_api_init', function(){
        register_rest_route('montheme/v1', '/demo/(?P<id>\d+)', [
            'method' => 'GET',
            'callback' => function(WP_REST_Request $request){
                // $response = new WP_REST_Response(['success' => 'Bonjour les gens']);
                // $response->set_status(201);
                // return $response;
                $postID = (int)$request->get_param('id');
                $post = get_post($postID);
                if($post === null){
                    return new WP_Error('rien', 'on as rien à dire', ['status' => 404]);
                }
                return $post->post_title;
            }, 
            'permission_callback' => function() {
                return current_user_can('edit_posts');
            }
        ]);
    });

    function bulledartReadData(){
        $data = wp_cache_get('data', 'bulledart');
        if($data === false){
            var_dump('je lis');
            $data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data');
            wp_cache_set('data', $data, 'bulledart', 60);
        }
        return $data;
    }

    if(isset($_GET['cachetest'])){
        var_dump(bulledartReadData());
        var_dump(bulledartReadData());
        var_dump(bulledartReadData());
        die();
    }
