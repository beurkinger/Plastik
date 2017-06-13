<?php
/* Page Auteur */

get_header();

/* Obtenir la liste des revues */
$listREVUES = listREVUES();

	// Affiche les informations de la page
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			$auteur = str_replace("/", " ", esc_attr(get_the_title()));	
			$tag_auteur = filter($auteur);
			$courriel = get_post_meta( get_the_ID(), 'courriel', true );
			$cv = get_post_meta( get_the_ID(), 'cv', true );
			
			$site_web = get_post_meta( get_the_ID(), 'site_web', true );
			// Gérer la présence ou l'absence de http
			if (strpos(strtolower($site_web), 'http://') !== 0 || strpos(strtolower($site_web), 'https://') !== 0) {
				$url = 'http://'.$site_web;
			} else {
				$url = $site_web;
			}

		}
	}

echo '<div id="author">
  <div class="content">
    <a href="/auteurs" class="back">Retour à l\'index</a>
    <article>
      <h1 class="author-name">'.$auteur.'</h1>
      <h2 class="author-title">'.get_post_meta( get_the_ID(), 'profession', true ).'</h2>
      <p>
        '.apply_filters('the_content', $post->post_content).'
      </p>
    </article>
  </div>
  <aside>';
  
	/* Cherche les articles de cet auteur */
	$articles = array();
	$i = 0;
	$args        = array(
		'post_type'      => 'post',
		'tag'			 => $tag_auteur
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_tags = get_the_tags();
			
			if (!isset($showArticles)) echo '<h2>Articles</h2>'; $showArticles = 1;
			
			echo '<p><a href="'.get_permalink().'"><em>'.esc_attr(get_the_title()).'</em></a><br/>
				  <strong>Plastik Nr. '.$post_tags[0]->name.'</strong>, '.$listREVUES[$post_tags[0]->name]['date'].'<br/>
				  '.$listREVUES[$post_tags[0]->name]['titre'].'
				</p>';
		}
	}
	if ( isset($courriel) && $courriel != "" || isset($site_web) && $site_web != "") {
		echo '<h2>Contact</h2>
		<p>';
		  if (isset($courriel) && $courriel != "") echo $courriel.'<br/><br/>';
		  if (isset($site_web) && $site_web != "") echo '<a href="'.$url.'" target="_blank">'.$site_web.'</a><br/><br/>';
		  if (isset($cv) && $cv != "") echo '<a href="'.$cv.'" target="_blank">Télécharger le CV</a><br/><br/>';
	echo '<br/><br/>
		</p>';
	}
  echo '</aside>
</div>';



echo '<div class="auteur-titre">
	<div class="auteur-img" style="background-image: url(';
	if ( has_post_thumbnail() ) {
		echo get_the_post_thumbnail_url( NULL, 'thumbnail', NULL );
	} else {
		echo themeCallImage('photo_manquante.svg');
	}
	echo ');">
    </div>
    <div class="auteur-header">
    	<a href="../"><img src="'.themeCallImage('back.svg').'"> Retour à l\'index</a>
    	<h1>'.$artiste.'</h1>
    </div>
</div>';

/* Afficher le site web de l'artiste s'il existe */
echo '<div class="auteur-details">
	<div class="auteur-contact">';

	if (isset($site_web) && $site_web != "") {
	echo '<a href="'.$site_web.'" target="_blank">Site web</a>';
	}
	
echo '</div>
	<div class="auteur-description">';

/* Afficher la biographie de l'artiste si elle existe */
	if (isset($str[0]) && $str[0] != "") {
		echo $str[0];
	}
	
    echo '</div>
</div>';

	/* Génère le tableau des oeuvres */
	/* Seulement 6 oeuvres peuvent être visible en même temps */
	$oeuvres = array();
	$i = 0;
	$args        = array(
		'post_type'      => 'oeuvre',
		'posts_per_page' => '6', /* Limitation */
		'tag'			 => $tag_artisite
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$oeuvres[$i]['url']    = get_the_post_thumbnail_url( NULL, 'thumbnail', NULL );
			$oeuvres[$i]['url_full']= get_the_post_thumbnail_url( NULL, 'large', NULL );
			$oeuvres[$i]['title'] = esc_attr(get_the_title());
			$oeuvres[$i]['date']  = get_the_date('Y');
			$i++;
		}
	}
	
	/* Affiche les oeuvres en fonction du tableau */
	$nb = count($oeuvres);
	if($nb > 0) {
		echo '<div class="auteur-artiste-galerie"';
		switch ($nb) {
			case 1:
				echo ' style="padding: 0 40% 80px 40%; width: 20%;"';
				break;
			case 2:
				echo ' style="padding: 0 30% 80px 30%; width: 40%;"';
				break;
			case 3:
				echo ' style="padding: 0 20% 80px 20%; width: 60%;"';
				break;
			case 4:
				echo ' style="padding: 0 10% 80px 10%; width: 80%;"';
				break;
		}
		echo '>
    			<ul>';
		foreach ($oeuvres as $oeuvre) {
			echo '<a href="'.$oeuvre['url_full'].'" data-lightbox="example-set"><li class="work_item" style="background-image: url(\''.$oeuvre['url'].'\'); background-position: center; background-size: cover;';
			echo ' width: '.(100/$nb).'%;';
			echo '"><div class="work_item_img"></div>
        		  <div class="titles"><h1>'.$oeuvre['title'].'<br>'.$oeuvre['date'].'</h1></div></li></a>';
		}
		echo '</ul>
			</div>';
	}

/* Afficher plus d'infos de l'artiste si elles existent */
	if (isset($str[1]) && $str[1] != "") {
		echo '<div class="auteur-supplement">'.$str[1].'</div>';
	}
	
get_footer();
?>