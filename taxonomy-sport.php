<?php get_header(); ?>

<h1><?php echo esc_html(get_queried_object()->name); ?></h1>

<p><?php echo esc_html(get_queried_object()->description); ?></p>

<?php get_template_part('parts/taxonomy-nav', 'post'); ?>

<?php if (have_posts()) : ?>

    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <div class="col-sm-4">
                <?php get_template_part('parts/card', 'post'); ?>
            </div>
        <?php endwhile ?>
        <?php bulledart_pagination(); ?>
    </div>

<?php else : ?>

    <h1>Pas d'articles</h1>

<?php endif ?>

<?php get_footer(); ?>