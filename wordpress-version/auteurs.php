<?php
/* Template Name: Auteurs */

get_header();

	// Affiche les informations de la page
	if (have_posts()) {
		while (have_posts()) {
			the_post();
		}
	}

/* Affiche les auteurs (Article de type : auteurs) */
$args  = array(
	'post_type'      => 'auteur',
	'orderby'		 => 'title',
	'order'   		 => 'ASC',
	'posts_per_page' => -1

);

/* Créer un tableau d'auteur classé par nom */
$nomArtistes = array();
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
	
	while ( $query->have_posts() ) {
		$query->the_post();
		$str = explode('/', esc_attr(get_the_title()));
		$nomArtistes[$str[1][0]][$str[1]] = array();
		$nomArtistes[$str[1][0]][$str[1]]['prenom'] = $str[0];
		$nomArtistes[$str[1][0]][$str[1]]['img'] = get_the_post_thumbnail_url( NULL, 'large', NULL );
		$nomArtistes[$str[1][0]][$str[1]]['lien'] = get_permalink();
		//$nomArtistes[substr($str[1], 0, 1)]['img'] = get_the_post_thumbnail_url( NULL, 'large', NULL );
	}
	
  // On trie le tableau des noms d'auteurs par ordre alphabétique	
  ksort($nomArtistes);
}

// Affiche les auteurs
echo '<div id="authors">';

$i = 0;
foreach ($nomArtistes as $lettre => $artiste){
	echo '<div class="boxes-container offset">
			<div class="box center letter-box">
		  	<h2>'.$lettre.'</h2>
			</div>
	  	  </div>
	  	  <div class="clearfix"></div>';
	foreach ($artiste as $nom => $info){
		echo '<div class="boxes-container';
		if ($i % 2) echo ' offset';
		$i++;
		echo '">
				<a href="'.$info['lien'].'"><div class="box pic-box" style="background: url(\''.$info['img'].'\') center center / cover no-repeat;">
				</div>
				<div class="box center name-box">
				  <h3>
					<strong>'.$nom.'</strong><br/>
					'.$info['prenom'].'
				  </h3>
				</div></a>
			  </div>
			  <div class="clearfix"></div>';
	}
}
echo '</div>';

get_footer();
?>