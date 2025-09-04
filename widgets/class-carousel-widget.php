<?php
if (!defined('ABSPATH')) exit;

class Carousel_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'carousel_widget',
            __('Carousel Posts', 'astra-child'),
            ['description' => __('Displays posts in scroll format', 'astra-child')]
        );
    }

    public function widget( $args, $instance ) {
    echo $args['before_widget'];

    $title         = !empty($instance['title']) ? $instance['title'] : __('Projects', 'astra-child');
    $num_posts     = !empty($instance['num_posts']) ? intval($instance['num_posts']) : -1;
    $show_excerpt  = !empty($instance['show_excerpt']);
    $card_width    = !empty($instance['card_width']) ? $instance['card_width'] : '850px';
    $overlay       = !empty($instance['overlay']);
    $overlay_color = !empty($instance['overlay_color']) ? $instance['overlay_color'] : 'rgba(0,0,0,0.5)';
    $sort_order    = !empty($instance['sort_order']) ? $instance['sort_order'] : 'DESC';
    $scroll_speed  = !empty($instance['scroll_speed']) ? intval($instance['scroll_speed']) : 500;
    $auto_scroll   = !empty($instance['automatic_scroll']);
    $category      = !empty($instance['category']) ? $instance['category'] : '';

    // Build dynamic classes
    $card_class    = $category ? sanitize_html_class($category . '-post-card') : 'carousel-post-card';
    $wrapper_class = $category ? sanitize_html_class($category . '-carousel-wrapper') : 'carousel-wrapper';

    echo '<h2>' . esc_html($title) . '</h2>';
    echo '<div class="scroll-wrapper ' . esc_attr($wrapper_class) . '" data-scroll-speed="' . esc_attr($scroll_speed) . '" data-auto-scroll="' . esc_attr($auto_scroll) . '">';
    echo '<button class="scroll-left">‹</button>';
    echo '<div class="scroll-container">';

        $query_args = [
            'posts_per_page' => $num_posts,
            'orderby'        => $sort_order === 'RAND' ? 'rand' : 'date',
            'order'          => $sort_order !== 'RAND' ? $sort_order : 'DESC',
        ];

        if ($category) {
            $query_args['category_name'] = $category;
        }

        $carousel_query = new WP_Query($query_args);

        if ($carousel_query->have_posts()) :
            while ($carousel_query->have_posts()) : $carousel_query->the_post();
                $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
                <a href="<?php echo esc_url(get_permalink()); ?>" class="card-link">
                    <div class="<?php echo esc_attr($card_class); ?>"
                         style="background-image: url('<?php echo esc_url($thumbnail); ?>'); width: <?php echo esc_attr($card_width); ?>;">
                        <?php if ($overlay) : ?>
                            <div class="card-overlay" style="background-color: <?php echo esc_attr($overlay_color); ?>;"></div>
                        <?php endif; ?>
                        <div class="card-content">
                            <h3><?php the_title(); ?></h3>
                            <?php if ($show_excerpt) : ?>
                                <p><?php the_excerpt(); ?></p>
                            <?php endif; ?>
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

    // admin form
    public function form( $instance ) {
        $title            = !empty($instance['title']) ? $instance['title'] : __('Projects', 'astra-child');
        $num_posts        = !empty($instance['num_posts']) ? intval($instance['num_posts']) : -1;
        $show_excerpt     = !empty($instance['show_excerpt']);
        $card_width       = !empty($instance['card_width']) ? $instance['card_width'] : '850px';
        $overlay          = !empty($instance['overlay']);
        $overlay_color    = !empty($instance['overlay_color']) ? $instance['overlay_color'] : 'rgba(0,0,0,0.5)';
        $sort_order       = !empty($instance['sort_order']) ? $instance['sort_order'] : 'DESC';
        $scroll_speed     = !empty($instance['scroll_speed']) ? intval($instance['scroll_speed']) : 300;
        $automatic_scroll = !empty($instance['automatic_scroll']);
        $category         = !empty($instance['category']) ? $instance['category'] : '';
        
        // get all categories
        $categories = get_categories(['hide_empty' => false]);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('num_posts'); ?>">Number of posts:</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('num_posts'); ?>"
                   name="<?php echo $this->get_field_name('num_posts'); ?>" type="number"
                   value="<?php echo esc_attr($num_posts); ?>" step="1" min="-1">
            <small>Use -1 to show all posts.</small>
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('category'); ?>">Category:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>"
                name="<?php echo $this->get_field_name('category'); ?>" type="text"
                value="<?php echo esc_attr($category); ?>" placeholder="e.g. projects, past-projects">
            <small>
                CSS classes will be generated automatically:<br>
                <code><?php echo $category ? esc_html($category) . '-carousel-wrapper' : 'carousel-wrapper'; ?></code> (wrapper)<br>
                <code><?php echo $category ? esc_html($category) . '-post-card' : 'carousel-post-card'; ?></code> (cards)
            </small>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_excerpt); ?>
                   id="<?php echo $this->get_field_id('show_excerpt'); ?>"
                   name="<?php echo $this->get_field_name('show_excerpt'); ?>" />
            <label for="<?php echo $this->get_field_id('show_excerpt'); ?>">Show post excerpt</label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('card_width'); ?>">Card width (px or %):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('card_width'); ?>"
                   name="<?php echo $this->get_field_name('card_width'); ?>" type="text"
                   value="<?php echo esc_attr($card_width); ?>">
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($overlay); ?>
                   id="<?php echo $this->get_field_id('overlay'); ?>"
                   name="<?php echo $this->get_field_name('overlay'); ?>" />
            <label for="<?php echo $this->get_field_id('overlay'); ?>">Enable overlay on image</label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('overlay_color'); ?>">Overlay color:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('overlay_color'); ?>"
                   name="<?php echo $this->get_field_name('overlay_color'); ?>" type="text"
                   value="<?php echo esc_attr($overlay_color); ?>">
            <small>Any valid CSS color (e.g., rgba(0,0,0,0.5) or #000000)</small>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sort_order'); ?>">Sort order:</label>
            <select id="<?php echo $this->get_field_id('sort_order'); ?>"
                    name="<?php echo $this->get_field_name('sort_order'); ?>">
                <option value="DESC" <?php selected($sort_order,'DESC'); ?>>Date (Newest First)</option>
                <option value="ASC" <?php selected($sort_order,'ASC'); ?>>Date (Oldest First)</option>
                <option value="RAND" <?php selected($sort_order,'RAND'); ?>>Random</option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('scroll_speed'); ?>">Scroll speed (ms):</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('scroll_speed'); ?>"
                   name="<?php echo $this->get_field_name('scroll_speed'); ?>" type="number"
                   value="<?php echo esc_attr($scroll_speed); ?>" step="50" min="50">
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($automatic_scroll); ?>
                   id="<?php echo $this->get_field_id('automatic_scroll'); ?>"
                   name="<?php echo $this->get_field_name('automatic_scroll'); ?>" />
            <label for="<?php echo $this->get_field_id('automatic_scroll'); ?>">Enable automatic scrolling</label>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title']            = sanitize_text_field( $new_instance['title'] );
        $instance['num_posts']        = intval( $new_instance['num_posts'] );
        $instance['show_excerpt']     = ! empty( $new_instance['show_excerpt'] );
        $instance['card_width']       = sanitize_text_field( $new_instance['card_width'] );
        $instance['overlay']          = ! empty( $new_instance['overlay'] );
        $instance['overlay_color']    = sanitize_text_field( $new_instance['overlay_color'] );
        $instance['sort_order']       = in_array( $new_instance['sort_order'], ['DESC','ASC','RAND'] ) ? $new_instance['sort_order'] : 'DESC';
        $instance['scroll_speed']     = ! empty( $new_instance['scroll_speed'] ) ? intval( $new_instance['scroll_speed'] ) : 3000;
        $instance['automatic_scroll'] = ! empty( $new_instance['automatic_scroll'] );
        $instance['category']         = sanitize_text_field( $new_instance['category'] );

        return $instance;
    }
}

// register widget
add_action('widgets_init', function(){
    register_widget('Carousel_Widget');
});
