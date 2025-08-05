<?php
/*
Template Name: Custom Home
*/
get_header(); ?>

<main id="main" class="site-main">
    <section id="research" class="post-section research-section">
        <h2>Research</h2>
        <div class="scroll-container">
            <?php
            $research_query = new WP_Query([
            'category_name' => 'research',
            'posts_per_page' => -1
            ]);
            if ($research_query->have_posts()) :
            while ($research_query->have_posts()) : $research_query->the_post(); ?>
                <div class="research-post-card">
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
            <button class="scroll-left">‹</button>
            <button class="scroll-right">›</button>
        </div>
    </section>
    <!-- People Section -->
    <section id="people" class="post-section section-people">
        <h2>People</h2>
        <div class="people-grid">
            <?php
            $people_query = new WP_Query([
                'post_type' => 'person',
                'posts_per_page' => -1
            ]);
            if ($people_query->have_posts()) :
                while ($people_query->have_posts()) : $people_query->the_post();
                    $link = get_field('external_link');
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    $name = get_the_title();
                    ?>
                    <a href="<?php echo esc_url($link); ?>" class="person-card">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>">
                        <div class="name-overlay"><?php echo esc_html($name); ?></div>
                    </a>
                <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <section id="highlight" class="post-section highlight-section">
        <?php
        $highlight_query = new WP_Query([
            'category_name' => 'research-highlights',
            'posts_per_page' => 2
        ]);
        if ($highlight_query->have_posts()) : ?>
            <div class="highlight-carousel">
            <?php while ($highlight_query->have_posts()) : $highlight_query->the_post(); 
                $background = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
                <a href="<?php the_permalink(); ?>" class="highlight-slide" style="background-image: url('<?php echo $background; ?>')">
                <h2 class="highlight-title"><?php the_title(); ?></h2>
                </a>
            <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>
    </section>
    <section id="news" class="post-section news-section">
        <h2>News</h2>
        <div class="scroll-container">
            <?php
            $news_query = new WP_Query([
            'category_name' => 'news',
            'posts_per_page' => -1
            ]);
            if ($news_query->have_posts()) :
            while ($news_query->have_posts()) : $news_query->the_post(); ?>
                <div class="news-post-card">
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
                </div>
            <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
            <button class="scroll-left">‹</button>
            <button class="scroll-right">›</button>
        </div>
    </section>        
</main>
<?php get_footer(); ?>