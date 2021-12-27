<?php

class SponsoMetaBox {

    const META_KEY = 'bulledart_sponso';
    const NONCE = '_bulledart_sponso_nonce';

    public static function register()
    {
        add_action('add_meta_boxes', [self::class, 'add'], 10, 2);
        add_action('save_post',  [self::class, 'save']);
    }

    public static function add($postType, $post)
    {
        if($postType === 'post' && current_user_can('publish_post', $post))
        {
            add_meta_box(self::META_KEY, 'Sponsoring', [self::class, 'render'], 'post', 'side');
        }
    }

    public static function render($post)
    {
        $value = get_post_meta($post->ID, self::META_KEY, true);
        wp_nonce_field(self::NONCE, self::NONCE);
        ?>
            <input type="hidden" name="<?php echo self::META_KEY; ?>" value="0">
            <label for="<?php echo self::META_KEY; ?>">Cet article est sponsorisé</label>
            <input type="checkbox" name="<?php echo self::META_KEY; ?>" value="1" <?php echo $value === '1' ? 'checked' : '' ?>> <!-- checked($value, '1'); -->
        <?php
    }

    public static function save($post)
    {
        if (array_key_exists(self::META_KEY, $_POST) && current_user_can('publish_post', $post) && wp_verify_nonce($_POST[self::NONCE], self::NONCE))
        {
           if ($_POST[self::META_KEY] === '0')
           {
                delete_post_meta($post, self::META_KEY);
           } else {
                update_post_meta($post, self::META_KEY, 1);
           }
        }
    }
}