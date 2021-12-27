<form class="d-flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input class="form-control me-2" name="s" type="search" placeholder="Search" aria-label="Search" value="<?php echo get_search_query(); ?>">
    <button class="btn btn-success" type="submit">Rechercher</button>
</form>