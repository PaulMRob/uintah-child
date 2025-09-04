<?php
/*
Template Name: Custom Home
*/
get_header(); ?>

<main id="main" class="site-main">

    <!-- Carousel Section (Projects) -->
    <section id="carousel-section" class="post-section carousel-section">
        <?php if ( is_active_sidebar( 'carousel-section' ) ) : ?>
            <?php dynamic_sidebar( 'carousel-section' ); ?>
        <?php else : ?>
            <p>Add Carousel widgets in Appearance → Widgets.</p>
        <?php endif; ?>
    </section>

    <!-- Feature Grid Section (People, Team, etc.) -->
    <section id="feature-grid-section" class="section feature-grid-section">
        <?php if ( is_active_sidebar( 'feature-grid-section' ) ) : ?>
            <?php dynamic_sidebar( 'feature-grid-section' ); ?>
        <?php else : ?>
            <p>Add Feature Grid widget in Appearance → Widgets.</p>
        <?php endif; ?>
    </section>

    <!-- Banner Mid Section (Highlights) -->
    <section id="banner-mid-section" class="highlight-section banner-mid-section">
        <?php if ( is_active_sidebar( 'banner-mid-section' ) ) : ?>
            <?php dynamic_sidebar( 'banner-mid-section' ); ?>
        <?php else : ?>
            <p>Add Mid-Page Banner (Banner-Mid) in Appearence → Widgets.</p>
        <?php endif; ?>
    </section>

    <!-- Carousel Alt Section (Past Projects) -->
    <section id="carousel-alt-section" class="post-section carousel-alt-section">
        <?php if ( is_active_sidebar( 'carousel-alt-section' ) ) : ?>
            <?php dynamic_sidebar( 'carousel-alt-section' ); ?>
        <?php else : ?>
            <p>Add Carousel Alt widgets in Appearance → Widgets.</p>
        <?php endif; ?>
    </section>

</main>

<?php get_footer(); ?>
