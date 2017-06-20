<?php
/* Template Name: Credit */

get_header();

	// Affiche les informations de la page
	if (have_posts()) {
		while (have_posts()) {
			the_post();
		}
	}

echo '<div id="contribute">
  <article>
    <h1>
      '.esc_attr(get_the_title()).'
    </h1>
    '.apply_filters('the_content', $post->post_content).'
  </article>
</div>';

get_footer();
?>