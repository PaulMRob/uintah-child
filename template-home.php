<?php
/*
Template Name: Custom Home
*/
get_header(); ?>

<main id="main" class="site-main">

<?php

$sections = [
    [
        'title' => 'Research',
        'slug' => 'research',
        'class' => 'section-research'
    ],
    [
        'title' => 'News',
        'slug' => 'news',
        'class' => 'section-news'
    ],
    [
        'title' => 'Publications',
        'slug' => 'publications',
        'class' => 'section-publications'
    ],
];

foreach ($sections as $section) :
    $query = new WP_Query([
        'category_name' => $section['slug'],
        'posts_per_page' => 3
    ]);
    if ($query->have_posts()) : ?>
    <section class="<?php echo esc_attr($section['class']); ?>">
        <h2><?php echo esc_html($section['title']); ?></h2>
        <div class="poster-wrapper">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article class="home-post">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="excerpt"><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php endif;
    wp_reset_postdata();
endforeach;
?>
</main>

<?php get_footer(); ?>