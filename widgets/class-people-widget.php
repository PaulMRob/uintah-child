<?php
class People_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'people_widget',
            __('People Widget', 'astra-child'),
            array('description' => __('Displays people in grid or row layout', 'astra-child'))
        );
    }

    public function widget($args, $instance) {
        $title      = !empty($instance['title']) ? $instance['title'] : __('People', 'astra-child');
        $layout     = !empty($instance['layout']) ? $instance['layout'] : 'grid';
        $image_size = !empty($instance['image_size']) ? intval($instance['image_size']) : 150;
        $show_name  = isset($instance['show_name']) ? (bool) $instance['show_name'] : true;

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        $people = new WP_Query(array(
            'post_type'      => 'people',
            'posts_per_page' => -1
        ));

        if ($people->have_posts()) {
            echo '<div class="people-widget people-layout-' . esc_attr($layout) . '">';

            while ($people->have_posts()) {
                $people->the_post();
                $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

                echo '<div class="person" style="width:' . esc_attr($image_size) . 'px">';
                if ($thumb_url) {
                    echo '<a href="' . get_permalink() . '">';
                    echo '<img src="' . esc_url($thumb_url) . '" alt="' . esc_attr(get_the_title()) . '" style="width:' . esc_attr($image_size) . 'px; height:' . esc_attr($image_size) . 'px; object-fit:cover;" />';
                    echo '</a>';
                }
                if ($show_name) {
                    echo '<div class="person-name">' . get_the_title() . '</div>';
                }
                echo '</div>';
            }

            echo '</div>';
            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title      = !empty($instance['title']) ? $instance['title'] : __('People', 'astra-child');
        $layout     = !empty($instance['layout']) ? $instance['layout'] : 'grid';
        $image_size = !empty($instance['image_size']) ? intval($instance['image_size']) : 150;
        $show_name  = isset($instance['show_name']) ? (bool) $instance['show_name'] : true;
        ?>

        <!-- Title -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <!-- Layout -->
        <p>
            <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout:'); ?></label>
            <select id="<?php echo $this->get_field_id('layout'); ?>"
                    name="<?php echo $this->get_field_name('layout'); ?>">
                <option value="grid" <?php selected($layout, 'grid'); ?>><?php _e('Grid'); ?></option>
                <option value="row" <?php selected($layout, 'row'); ?>><?php _e('Row'); ?></option>
            </select>
        </p>

        <!-- Image Size -->
        <p>
            <label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image Size (px):'); ?></label>
            <input class="small-text" id="<?php echo $this->get_field_id('image_size'); ?>"
                   name="<?php echo $this->get_field_name('image_size'); ?>" type="number"
                   value="<?php echo esc_attr($image_size); ?>" />
        </p>

        <!-- Show Name -->
        <p>
            <input class="checkbox" type="checkbox"
                   <?php checked($show_name); ?>
                   id="<?php echo $this->get_field_id('show_name'); ?>"
                   name="<?php echo $this->get_field_name('show_name'); ?>" />
            <label for="<?php echo $this->get_field_id('show_name'); ?>"><?php _e('Show Person Name'); ?></label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title']      = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['layout']     = (!empty($new_instance['layout'])) ? strip_tags($new_instance['layout']) : 'grid';
        $instance['image_size'] = (!empty($new_instance['image_size'])) ? intval($new_instance['image_size']) : 150;
        $instance['show_name']  = isset($new_instance['show_name']) ? (bool) $new_instance['show_name'] : false;
        return $instance;
    }
}

//register widget
add_action('widgets_init', function(){
    register_widget('People_Widget');
});