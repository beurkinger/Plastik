<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

 /* Utilisé pour les recherches ici */
 
get_header();

if(is_search()) {

?>
<div id="search">
	<div class="content">
		<article>
<?php
	global $query_string;

	$query_args = explode("&", $query_string);

  echo '
      <form action="'.site_url().'" method="get">
        <input type="text" name="s" id="s" class="search-input" value="'.$_GET['s'].'" placeholder="Rechercher"/>
        <button type="submit" class="search-btn"></button>
        <div class="search-empty"></div>
      </form>';

	if (htmlspecialchars(urldecode(searchDisplayVar($query_string))) != "") {

		$search_query = array();
	
		foreach($query_args as $key => $string) {
			$query_split = explode("=", $string);
			$search_query[$query_split[0]] = urldecode($query_split[1]);
		} // foreach
	
		$search = new WP_Query($search_query);
		$result = ($search->posts);
	
		$nbSearchResults = 0;
	
	
		echo '<h2 class="search-content">
			Résultats de la recherche avec le terme <br>
			<span>&laquo; '.htmlspecialchars(urldecode(searchDisplayVar($query_string))).'&raquo;</span>
		  </h2>';
	
		foreach($result as $post) {
			$type = $post->post_type;
			$post_tags = get_the_tags();
			$url = "";
	
			/* Créer le lien en fonction du type */
			if ($post->post_type == 'post') {
				$titre = get_the_title();
				$txt = preg_replace(array('/<!--nextpage-->/','/<!--more-->/','/<strong>/','/<\/strong>/','/{|<h1>|<h2>|<h3>|<h4>/'), '',tronquerTxt(apply_filters('the_content', $post->post_content), 260));
				$url = get_permalink();
				$date = get_the_date();
				
			  foreach ($post_tags as $tag) {
				  if ($tag->name > 0) {
					  $num = $tag->name;
				  } else {
					  if(!isset($auteur)) {
						  $auteur = $tag->name;
					  } else {
						  $auteur = $auteur.' et '.$tag->name;
					  }
				  }
			  }
				
			}
	
	
	
			if ($url != "") {
			$nbSearchResults++;
			echo '<a class="result num-'.$num.'" href="'.$url.'">
			<h3 class="result-title">
			  <em>'.$titre.',</em>
			  '.$auteur.',
			  <strong>Plastik Nr '.$num.'</strong>
			</h3>
			<div class="result-content">
			  '.$txt.'
			</div>
			<p class="result-date">
			  '.$date.'
			</p>
		  </a>';
			}
			
		}
			
		// Afficher le résultat des recherches s'il y a au moins 1 résultat sinon afficher un message d'alerte
		if ($nbSearchResults == 0) {
			echo '<h1>Aucun résultat trouvé pour votre recherche</h1>';
		}
	}

echo '</article>
  </div>
</div>';

} elseif (have_posts()) {

add_action( 'wp_enqueue_scripts', 'loadIndexPostCss' );

?>
	<div class="left" id="columnLeft">
		<h2 class="lTitle"><?php echo $post->post_title; ?></h2>
		<div class="lpContent"><?php echo $post->post_content; ?></div>
	</div>
    
<?php
}

get_footer();
?>