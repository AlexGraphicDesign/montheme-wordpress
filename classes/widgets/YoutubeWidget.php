<?php

class YoutubeWidget extends WP_Widget {

    public function __construct() {
        parent::__construct('youtube_widget', 'Youtube Widget');
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if(isset($instance['title'])){
            $title = apply_filters('widget_title', $instance['title']);
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        echo '<div class="widget-container">';
            echo '<iframe class="widget-youtube-iframe" src="https://www.youtube.com/embed/'. esc_attr($youtube) .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        echo '</div>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Titre</label>
            <input 
                class="widefat" 
                type="text" 
                id="<?php echo $this->get_field_id('title'); ?>" 
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo esc_attr($title); ?>"
            >
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>">ID Youtube</label>
            <input 
                class="widefat" 
                type="text" 
                id="<?php echo $this->get_field_id('youtube'); ?>" 
                name="<?php echo $this->get_field_name('youtube'); ?>"
                value="<?php echo esc_attr($youtube); ?>"
            >
        </p>
        <?php
    }

    public function update($newInstance, $oldInstance) {
        return [
            'title' => $newInstance['title'],
            'youtube' => $newInstance['youtube']
        ];
    }

}