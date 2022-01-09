<?php get_header(); ?>

<form class="row row-cols-lg-auto g-3 align-items-center">
  <div class="col-12">
    <input type="search" name="s" class="form-control" value="<?php echo get_search_query() ?>" placeholder="Votre recherche">
  </div>

  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="1" name="sponso" id="inlineFormCheck" <?php echo checked('1', get_query_var('sponso')); ?>>
      <label class="form-check-label" for="inlineFormCheck">
        Article sponsorisé
      </label>
    </div>
  </div>

  <div class="col-12">
    <button type="submit" class="btn btn-primary">Rechercher</button>
  </div>
</form>

<!-- <h1 class="mb-4">Résultat de recherche : <?php //echo get_search_query() ?></h1> -->
<h1 class="mb-4"><?php echo sprintf(apply_filters('bulledart_search_title', 'Résultat de votre recherche \'%s\''), get_search_query()); ?></h1>

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