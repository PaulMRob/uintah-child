<?php
class People_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'people_widget',
            __('People', 'astra-child'),
            ['description' => __('Displays People in a grid', 'astra-child')]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $people_query = new WP_Query([
            'post_type' => 'people',
            'posts_per_page' => -1,
        ]);

        if ( $people_query->have_posts() ) :
            echo '<div class="people-grid">';
            while ( $people_query->have_posts() ) : $people_query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                <a href="<?php the_permalink(); ?>" class="person-card">
                    <?php if ( $image_url ) : ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <div class="name-overlay"><?php the_title(); ?></div>
                </a>
                <?php
            endwhile;
            echo '</div>';
        endif;

        wp_reset_postdata();
        echo $args['after_widget'];
    }
}

add_action('widgets_init', function() {
    register_widget('People_Widget');
});
