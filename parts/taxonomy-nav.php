<?php $sports = get_terms(['taxonomy' => 'sport']); ?>
<?php if (is_array($sports)): ?>
<ul class="nav nav-pills my-4">
    <?php 
        foreach($sports as $sport) :
    ?>
        <li class="nav-item">
            <a href="<?php echo get_term_link($sport); ?>" class="nav-link <?php echo is_tax('sport', $sport->term_id) ? 'active' : ''; ?>"><?php echo $sport->name; ?></a>
        </li>
    <?php 
        endforeach;
    ?>
</ul>
<?php endif ?>