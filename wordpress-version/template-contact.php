<?php
/**
 * Template Name: Contact
 */
get_header();

	// Affiche les informations de la page
	if (have_posts()) {
		while (have_posts()) {
			the_post();
		}
	}

	$contentWP = apply_filters('the_content', $post->post_content);
	$str = explode('<!--more-->', $contentWP);

echo '
<div class="contact-page">
<div class="contact-form"><h1>'.esc_attr(get_the_title()).'</h1>
	<div class="contact-form-wp">'.$str[2].'</div>
</div>
<div class="contact-info"><div class="contact-info-cp">&nbsp;<img src="'.themeCallImage("creations-patrimoines-logo.svg").'" alt="Créations & Patrimoines - Logo"><br>&nbsp;<br>
'.str_replace(array('<p>','</p>'), array('',''), $str[0]).'</div>'.$str[1].'</div>
</div>';

get_footer();
?>