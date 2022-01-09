<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="img-fluid">
        <?php the_content(); ?>

        <?php if(get_field('jardin') === true): ?>
            <p><strong>Jardin :</strong> <?php echo get_field('surface_jardin'); ?> m²</p>
        <?php endif ?>

        <?php echo get_field('surface'); ?>
    <?php endwhile ?>
<?php endif ?>

<?php get_footer(); ?>