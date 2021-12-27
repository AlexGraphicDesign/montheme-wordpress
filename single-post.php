<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <?php if(get_post_meta(get_the_ID(), SponsoMetaBox::META_KEY, true) === '1'): ?>
            <div class="alert alert-info">
                Cet article est sponsorisé
            </div>
        <?php endif ?>
        <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="img-fluid">
        <?php the_content(); ?>
    <?php endwhile ?>
<?php endif ?>

<?php get_footer(); ?>