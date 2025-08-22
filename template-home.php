<?php
/*
Template Name: Custom Home
*/
get_header(); ?>

<main id="main" class="site-main">

<!-- Project Section -->
 <section id="project" class="post-section project-section">
  <!-- <h2>Projects</h2> -->
  <?php if ( is_active_sidebar( 'project-section' ) ) : ?>
      <?php dynamic_sidebar( 'project-section' ); ?>
  <?php else: ?>
      <p>Add Project widgets in Appearance → Widgets.</p>
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
        


<!-- past projects Section -->
 <section id="past-projects" class="post-section past-projects-section">
  <!-- <h2>Pas Projects</h2> -->
  <?php if ( is_active_sidebar( 'past-projects-section' ) ) : ?>
      <?php dynamic_sidebar( 'past-projects-section' ); ?>
  <?php else: ?>
      <p>Add Pas Projects widgets in Appearance → Widgets.</p>
  <?php endif; ?>
</section>
</main>

<?php get_footer(); ?>
