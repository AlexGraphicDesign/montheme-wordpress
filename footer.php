    </div>
    <footer>
    <?php wp_nav_menu([
        'theme_location' => 'footer', 
        'container' => 'false',
        'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0'
    ]); ?>
    </footer>
    <div>
        <?php echo get_option('agence_horaires'); ?>
    </div>
    <?php wp_footer() ?>
    </body>
</html>