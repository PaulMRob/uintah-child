<?php
if (!defined('ABSPATH')) exit;

class Highlight_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'highlight_widget',
            __('Highlight Posts', 'astra-child'),
            [
                'description' => __('Displays Research Highlights posts', 'astra-child')
            ]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        // Widget content wrapper
        echo '<div class="highlight-widget-wrapper">';

        // Query the latest research-highlights posts
        $highlight_query = new WP_Query([
            'post_type'      => 'post',
            'category_name'  => 'research-highlights',
            'posts_per_page' => 1,
        ]);

        if ( $highlight_query->have_posts() ) :
            while ( $highlight_query->have_posts() ) : $highlight_query->the_post();
                $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                ?>
                <div class="highlight-image-wrapper">
                    <?php if ( $image_url ): ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>" class="highlight-image">
                    <?php endif; ?>

                    <div class="highlight-overlay">
                        <h2 class="highlight-title"><?php the_title(); ?></h2>
                        <a href="<?php the_permalink(); ?>" class="highlight-button">Read More</a>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No highlights found.</p>';
        endif;

        echo '</div>'; // end widget wrapper

        echo $args['after_widget'];
    }
}

// Register the widget
add_action('widgets_init', function() {
    register_widget('Highlight_Widget');
});
