<?php
/* Template Name: Numeros */

/* Obtenir la liste des articles */
$listARTICLES = listARTICLES();

/* Obtenir la liste des revues */
$listREVUES = listREVUES('reverse');

get_header();

	// Affiche les informations de la page
	if (have_posts()) {
		while (have_posts()) {
			the_post();
		}
	}
	
	echo '<div id="magazines">';
	$i = 0;		

	// Liste les numéros disponibles dans le menu
	foreach ($listREVUES as $key => $revue) {
			
	  // Créer le lien vers ces numéros
	  if (isset($listARTICLES[$revue['numero']]['edito'])) {
		  $tabARTICLES = $listARTICLES[$revue['numero']]['edito'];
	  } else {
		  $tabARTICLES = $listARTICLES[$revue['numero']]['article'];
	  }
	  foreach ($tabARTICLES as $article) {
		  echo '<a href="'.$article['lien'].'">';
		  break;
	  }
			
			echo '<div class="boxes-container';
			if ($i % 2) echo ' offset inverse';
			$i++;
			echo '">
					<div class="box number-box">
					  <h4>Nr</h4>
					  <h2>'.$revue['numero'].'</h2>
					</div>
					<div class="box" style="background: url(\''.$revue['img_full'].'\') center center / cover no-repeat;">
					</div>
					<div class="box center infos-box">
					  <h3>'.$revue['titre'].'</h3>
					</div>
				  </div></a>
				  <div class="clearfix"></div>';
	}
	
	echo '</div>';

get_footer();
?>