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

        <?php
            if(comments_open() || get_comments_number()){
                comments_template();
            }
        ?>

        <h2>Articles similaires</h2>
        <div class="row">
            <?php
                $sports = array_map(function($term){
                    return $term->term_id;
                },get_the_terms(get_post(), 'sport'));
                $query = new WP_Query([
                    'post_not_in' => [get_the_ID()],
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'orderby' => 'rand',
                    'tax_query' => [
                        [
                            'taxonomy' => 'sport',
                            'terms' => $sports
                        ]
                    ],
                    'meta_query' => [
                        [
                            'key' => SponsoMetaBox::META_KEY,
                            'compare' => 'EXISTS'
                        ]
                    ]
                ]);
            ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="col-sm-4">
                    <?php get_template_part('parts/card', 'post'); ?>
                </div>
            <?php endwhile ?>
        </div>

        <?php wp_reset_postdata(); ?>

    <?php endwhile ?>
<?php endif ?>

<?php get_footer(); ?>