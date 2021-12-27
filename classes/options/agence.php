<?php

class AgenceMenuPage {

    const GROUP = 'agence_options';
    
    public static function register()
    {
        add_action('admin_menu', [self::class, 'addMenu']);
        add_action('admin_init', [self::class, 'registerSettings']);
        add_action('admin_enqueue_scripts', [self::class, 'registerScripts']);
    }

    public static function registerScripts($suffix)
    {
        if($suffix === 'settings_page_agence_options')
        {
            wp_register_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], false);
            wp_register_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], false, true);
            wp_register_script('bulledart_admin', get_template_directory_uri() . '/assets/admin.js', ['flatpickr'], false, true);
            wp_enqueue_script('bulledart_admin');
            wp_enqueue_style('flatpickr');
        }
    }

    public static function registerSettings()
    {
        register_setting(self::GROUP, 'agence_horaires');
        register_setting(self::GROUP, 'agence_date');
        add_settings_section('agence_option_section', 'Paramètres', function(){
            echo 'Ici, on gère les paramètres de l\'agence';
        }, self::GROUP);
        add_settings_field('agence_option_horaires', 'Horaires d\'ouverture', function(){
            ?>
                <textarea name="agence_horaires" cols="30" rows="10" style="width: 100%;"><?php echo esc_html(get_option('agence_horaires')); ?></textarea>
            <?php
        }, self::GROUP, 'agence_option_section');
        add_settings_field('agence_option_date', 'Date d\'ouverture', function(){
            ?>
                <input class="bulledart_datepicker" type="text" name="agence_date" value="<?php echo esc_attr(get_option('agence_date')); ?>">
            <?php
        }, self::GROUP, 'agence_option_section');
    }
    
    public static function addMenu() 
    {
        add_options_page("Gestion de l'agence", "Agence", "manage_options", self::GROUP, [self::class, 'render']);
    }

    public static function render()
    {
        ?>
            <h1>Gestion de l'agence</h1>
            <form action="options.php" method="post">
                <?php 
                    settings_fields(self::GROUP);
                    do_settings_sections(self::GROUP);
                    submit_button(); 
                ?>
            </form>
        <?php
    }
}