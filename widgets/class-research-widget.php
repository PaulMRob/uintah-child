<?php
class Research_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'research_widget',
            __('Research Posts', 'astra-child'),
            ['description' => __('Displays Research posts in scroll format', 'astra-child')]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<div class="scroll-wrapper">';
        echo '<button class="scroll-left">‹</button>';
        echo '<div class="scroll-container">';

        $research_query = new WP_Query([
            'category_name' => 'research',
            'posts_per_page' => -1
        ]);
        if ($research_query->have_posts()) :
            while ($research_query->have_posts()) : $research_query->the_post(); ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="card-link">
                    <div class="research-post-card" 
                        style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
                        <div class="card-content">
                            <h3><?php the_title(); ?></h3>
                            <p><?php the_excerpt(); ?></p>
                        </div>
                    </div>
                </a>
            <?php endwhile;
        endif;
        wp_reset_postdata();

        echo '</div>';
        echo '<button class="scroll-right">›</button>';
        echo '</div>';
        echo $args['after_widget'];
    }
}
add_action('widgets_init', function(){
    register_widget('Research_Widget');
});
