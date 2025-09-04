<?php
if (!defined('ABSPATH')) exit;

class Banner_Mid_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'banner_mid_widget',
            __('Banner Mid Posts', 'astra-child'),
            [
                'description' => __('Displays the latest post from a chosen category in a banner layout', 'astra-child')
            ]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $category   = !empty($instance['category']) ? sanitize_text_field($instance['category']) : 'research-highlights';
        $title      = !empty($instance['title']) ? sanitize_text_field($instance['title']) : '';
        $button_text = !empty($instance['button_text']) ? sanitize_text_field($instance['button_text']) : 'Read More';

        // Wrapper class uses category for easier CSS targeting
        $wrapper_class = $category . '-banner-wrapper';

        echo '<div class="' . esc_attr($wrapper_class) . '">';

        $query = new WP_Query([
            'post_type'      => 'post',
            'category_name'  => $category,
            'posts_per_page' => 1,
        ]);

        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                ?>
                <div class="<?php echo esc_attr($category); ?>-banner-image-wrapper">
                    <?php if ( $image_url ): ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>" class="<?php echo esc_attr($category); ?>-banner-image">
                    <?php endif; ?>

                    <div class="<?php echo esc_attr($category); ?>-banner-overlay">
                        <?php if ( $title ): ?>
                            <h2 class="<?php echo esc_attr($category); ?>-banner-title"><?php echo esc_html($title); ?></h2>
                        <?php else: ?>
                            <h2 class="<?php echo esc_attr($category); ?>-banner-title"><?php the_title(); ?></h2>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($category); ?>-banner-button">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No posts found in ' . esc_html($category) . '.</p>';
        endif;

        echo '</div>'; // end wrapper
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title       = !empty($instance['title']) ? $instance['title'] : '';
        $category    = !empty($instance['category']) ? $instance['category'] : 'research-highlights';
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : 'Read More';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Custom Title (optional):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>">Category (slug):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>"
                   name="<?php echo $this->get_field_name('category'); ?>" type="text"
                   value="<?php echo esc_attr($category); ?>">
            <small>Example: research-highlights, news, events</small><br>
            <small>
                Wrapper classes will include: 
                <code><?php echo $category ? esc_html($category) . '-banner-wrapper' : 'banner-wrapper'; ?></code>
            </small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('button_text'); ?>">Button Text:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>"
                   name="<?php echo $this->get_field_name('button_text'); ?>" type="text"
                   value="<?php echo esc_attr($button_text); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title']       = sanitize_text_field( $new_instance['title'] );
        $instance['category']    = sanitize_text_field( $new_instance['category'] );
        $instance['button_text'] = sanitize_text_field( $new_instance['button_text'] );
        return $instance;
    }
}

// Register the widget
add_action('widgets_init', function() {
    register_widget('Banner_Mid_Widget');
});
