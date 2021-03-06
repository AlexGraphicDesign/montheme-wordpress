<?php
/** 
 * Template Name: Page avec bannière
 * Template Post Type: page, post
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <p>La bannière</p>
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="img-fluid">
        <?php the_content(); ?>
    <?php endwhile ?>
<?php endif ?>

<?php get_footer(); ?>