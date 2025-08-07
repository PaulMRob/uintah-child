<?php
/*
Template Name: Custom Home
*/
get_header(); ?>

<main id="main" class="site-main">

<!-- Research Section -->
<section id="research" class="post-section research-section">
    <h2>Research</h2>
    <div class="scroll-wrapper">
        <button class="scroll-left">‹</button>
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
        </div>
        <button class="scroll-right">›</button>
    </div>
</section>


<!-- People Section -->
<section class="section people-section">
    <h2 class="section-title">People</h2>
    <div class="people-grid">
        <?php
        $people_query = new WP_Query([
            'post_type' => 'people',
            'posts_per_page' => -1,
        ]);
        if ($people_query->have_posts()) :
            while ($people_query->have_posts()) : $people_query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                <a href="<?php the_permalink(); ?>" class="person-card">
                    <?php if ($image_url): ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <div class="name-overlay"><?php the_title(); ?></div>
                </a>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<!-- Highlight Section -->
<section id="highlight-section" class="highlight-section">
  <?php
    $highlight_query = new WP_Query(array(
      'post_type' => 'post',
      'category_name' => 'highlight',
      'posts_per_page' => 1
    ));

    if ($highlight_query->have_posts()) :
      while ($highlight_query->have_posts()) : $highlight_query->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  ?>
    <div class="highlight-image-wrapper">
      <?php if ($image_url): ?>
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" class="highlight-image">
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
  ?>
</section>

<!-- News Section -->
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
