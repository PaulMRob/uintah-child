<?php
/*
Template Name: Custom Home
*/
get_header(); ?>

<main id="main" class="site-main">

<!-- Research Section -->
 <section id="research" class="post-section research-section">
  <!-- <h2>Research</h2> -->
  <?php if ( is_active_sidebar( 'research-section' ) ) : ?>
      <?php dynamic_sidebar( 'research-section' ); ?>
  <?php else: ?>
      <p>Add Research widgets in Appearance → Widgets.</p>
  <?php endif; ?>
</section>


<!-- People Section -->
<section class="section people-section">
    <h2 class="section-title">People</h2>

    <?php 
    if ( is_active_sidebar( 'people-section' ) ) : 
        dynamic_sidebar( 'people-section' ); 
    else : 
        echo '<p>No people found. Please add the People Widget.</p>';
    endif; 
    ?>
</section>

<!-- Highlight Section -->
<section id="highlight-section" class="highlight-section">
    <?php if ( is_active_sidebar( 'highlight-section' ) ) : ?>
        <?php dynamic_sidebar( 'highlight-section' ); ?>
    <?php else : 
      echo '<p>No highlights found. Please add the Highlight Widget.</p>';
    endif; 
    ?>
</section>
        


<!-- News Section -->
 <section id="news" class="post-section news-section">
  <!-- <h2>News</h2> -->
  <?php if ( is_active_sidebar( 'news-section' ) ) : ?>
      <?php dynamic_sidebar( 'news-section' ); ?>
  <?php else: ?>
      <p>Add News widgets in Appearance → Widgets.</p>
  <?php endif; ?>
</section>
</main>

<?php get_footer(); ?>
