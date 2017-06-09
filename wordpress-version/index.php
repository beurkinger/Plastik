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

	global $query_string;

	$query_args = explode("&", $query_string);
	$search_query = array();

	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		$search_query[$query_split[0]] = urldecode($query_split[1]);
	} // foreach

	$search = new WP_Query($search_query);
	$result = ($search->posts);

	$nbSearchResults = 0;
	
	echo '<div class="page-full">
		<h1>Résultats de la recherche <i>« '.htmlspecialchars(urldecode(searchDisplayVar($query_string))).' »</i></h1>
		<div class="resultat-search">
	';
	

	foreach($result as $post) {
		$numero = get_post_meta( get_the_ID(), 'numero', true );
		$type = $post->post_type;
		$post_tags = get_the_tags();
		$url = "";

		/* Créer le lien en fonction du type */
		switch($type) {
			case 'expo':
				$genre = 'Expositions';
				$titre = get_the_title();
				$num = $post_tags[0]->name;
				$str = preg_replace(array('#<p>#','#</p>#','#<h1>#','#</h1>#','#<h2>#','#</h2>#'), array('','','<b>','</b>','<b>','</b>'), apply_filters('the_content', $post->post_content));
				$url = get_permalink();
				break;
			case 'lieu':
				$genre = 'Lieux';
				$titre = get_the_title();
				$num = $post_tags[0]->name;
				$str = preg_replace(array('#<p>#','#</p>#','#<h1>#','#</h1>#','#<h2>#','#</h2>#'), array('','','<b>','</b>','<b>','</b>'), apply_filters('the_content', $post->post_content));
				$str = preg_replace(array('#<p>#','#</p>#','#<h1>#','#</h1>#','#<h2>#','#</h2>#'), array('','','<b>','</b>','<b>','</b>'), apply_filters('the_content', $post->post_content));
				$url = get_permalink();
				break;
			case 'artiste':
				$genre = 'Artistes';
				$titre = str_replace("/", " ", esc_attr(get_the_title()));
				$num = $post->name;
				$str = preg_replace(array('#<p>#','#</p>#','#<h1>#','#</h1>#','#<h2>#','#</h2>#'), array('','','<b>','</b>','<b>','</b>'), apply_filters('the_content', $post->post_content));
				$url = get_permalink();
				break;
		}

		if ($url != "") {
		$nbSearchResults++;
		echo '<article>
				<h2>'.$genre.' <strong>'.$num.'</strong> <em>'.$titre.'</em></h2>
				<div class="resultat-info">
					<p class="resultat-txt">'.tronquerTxt($str, 475).'</p>
					<p class="resultat-link"><a href="'.$url.'">En savoir +</a></p>
				</div>
			</article>';
		}
		
	}
		
	// Afficher le résultat des recherches s'il y a au moins 1 résultat sinon afficher un message d'alerte
	if ($nbSearchResults == 0) {
		echo '<div class="cadreRechercheEmpty"><h1>Aucun résultat trouvé pour votre recherche</h1></div>';
	}
echo '</div>
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