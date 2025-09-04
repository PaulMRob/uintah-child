<?php
if (!defined('ABSPATH')) exit;

class Feature_Grid_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'feature_grid_widget',
            __('Feature Grid', 'astra-child'),
            ['description' => __('Displays posts in a grid (e.g., People, Team, Projects) with optional category filtering', 'astra-child')]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title      = !empty($instance['title']) ? sanitize_text_field($instance['title']) : '';
        $post_type  = !empty($instance['post_type']) ? sanitize_text_field($instance['post_type']) : 'people';
        $num_posts  = !empty($instance['num_posts']) ? intval($instance['num_posts']) : -1;
        $category   = !empty($instance['category']) ? sanitize_text_field($instance['category']) : '';

        if ( $title ) {
            echo '<h2 class="feature-grid-title">' . esc_html($title) . '</h2>';
        }

        $query_args = [
            'post_type'      => $post_type,
            'posts_per_page' => $num_posts,
        ];

        // Apply category filter if provided
        if ( $category ) {
            // Default 'category_name' works for 'post', for custom post types you can use 'tax_query'
            if ( $post_type === 'post' ) {
                $query_args['category_name'] = $category;
            } else {
                $query_args['tax_query'] = [
                    [
                        'taxonomy' => $category,
                        'field'    => 'slug',
                        'terms'    => $category,
                    ],
                ];
            }
        }

        $query = new WP_Query($query_args);

        if ( $query->have_posts() ) :
            echo '<div class="' . esc_attr($post_type) . '-grid feature-grid">';
            while ( $query->have_posts() ) : $query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                <a href="<?php the_permalink(); ?>" class="<?php echo esc_attr($post_type); ?>-card feature-card">
                    <?php if ( $image_url ) : ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <div class="name-overlay"><?php the_title(); ?></div>
                </a>
                <?php
            endwhile;
            echo '</div>';
        else :
            echo '<p>No posts found for post type: ' . esc_html($post_type);
            if ( $category ) echo ' in category: ' . esc_html($category);
            echo '.</p>';
        endif;

        wp_reset_postdata();
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title     = !empty($instance['title']) ? $instance['title'] : '';
        $post_type = !empty($instance['post_type']) ? $instance['post_type'] : 'people';
        $num_posts = !empty($instance['num_posts']) ? intval($instance['num_posts']) : -1;
        $category  = !empty($instance['category']) ? $instance['category'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title (optional):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_type'); ?>">Post Type:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>"
                   name="<?php echo $this->get_field_name('post_type'); ?>" type="text"
                   value="<?php echo esc_attr($post_type); ?>">
            <small>Example: people, post, projects</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>">Category / Taxonomy (optional):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>"
                   name="<?php echo $this->get_field_name('category'); ?>" type="text"
                   value="<?php echo esc_attr($category); ?>">
            <small>
                For 'post' type: enter category slug.<br>
                For custom post types: enter taxonomy slug.
            </small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('num_posts'); ?>">Number of posts:</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('num_posts'); ?>"
                   name="<?php echo $this->get_field_name('num_posts'); ?>" type="number"
                   value="<?php echo esc_attr($num_posts); ?>" step="1" min="-1">
            <small>Use -1 to show all posts.</small>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title']     = sanitize_text_field( $new_instance['title'] );
        $instance['post_type'] = sanitize_text_field( $new_instance['post_type'] );
        $instance['category']  = sanitize_text_field( $new_instance['category'] );
        $instance['num_posts'] = intval( $new_instance['num_posts'] );
        return $instance;
    }
}

// Register widget
add_action('widgets_init', function() {
    register_widget('Feature_Grid_Widget');
});
