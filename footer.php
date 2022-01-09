    </div>
    <footer>
    <?php wp_nav_menu([
        'theme_location' => 'footer', 
        'container' => 'false',
        'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0'
    ]); 
    
    //the_widget(YoutubeWidget::class, ['title' => 'Salut', 'youtube' => 'rQXxYr_YcE4']);

    ?>
    </footer>
    <div class="container">
        <div class="row">
            <?php echo get_option('agence_horaires'); ?>
        </div>
    </div>
    <?php wp_footer() ?>
    </body>
</html>