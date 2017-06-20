<?php
/* Page Article */

get_header();

/* Obtenir la liste des revues */
$listREVUES = listREVUES('reverse');

/* Obtenir la liste des articles */
$listARTICLES = listARTICLES();

	// Affiche les informations de la page
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			$post_tags = get_the_tags();
			$pdf = get_post_meta( get_the_ID(), 'pdf', true );
			$contentWP = apply_filters('the_content', $post->post_content);
			$issn = get_post_meta( get_the_ID(), 'ISSN', true );

			foreach ($post_tags as $tag) {
				if ($tag->name > 0) {
					$tagRevue = $tag->name;
				} else {
					if (!isset($tagAuteur)) {
						$tagAuteur = $tag->name;
					} else {
						$tagAuteur = $tagAuteur.' et '.$tag->name;
					}
				}
			}
		}
	}

	/* Générer les notes de bas de page */
	$note = 1; /* Numéro de la première note */
	$contentWP = str_replace(array("\r\n", "\r", "\n", PHP_EOL, chr(10), chr(13), chr(10).chr(13)), "", $contentWP);
	preg_match_all('/\{\{(.*?)\}\}/', $contentWP, $notes);
	while (strpos($contentWP, '{{') !== false && strpos($contentWP, '}}') !== false) {
		if ((strpos($contentWP, '{{') == false && strpos($contentWP, '}}') !== false) || (strpos($contentWP, '{{') !== false && strpos($contentWP, '}}') == false)) die('<strong style="color: #F00">Erreur d\'ouverture {{ fermeture }} dans les notes de bas de page');
		$contentWP = preg_replace(array('/\{\{(.*?)\}\}/'), '<a id="texte_note-'.$note.'" class="note-ref" name="texte_note-'.$note.'" href="#note-'.$note.'"><sup>'.$note.'</sup></a>', $contentWP, 1);
		$note++;
		if($note > 100) break; /* Casser une possible boucle infini si les notes de bas de page ont été mal remplit */
	}

	/* Générer les images intégrées */
	$img = 1;
	preg_match_all('/<blockquote(.*?)>((.|\n)*?)(<\/blockquote>)/i', $contentWP, $imgs);
	while (strpos($contentWP, '<blockquote>') !== false && strpos($contentWP, '</blockquote>') !== false) {
		if ((strpos($contentWP, '<blockquote>') == false && strpos($contentWP, '</blockquote>') !== false) || (strpos($contentWP, '<blockquote>') !== false && strpos($contentWP, '</blockquote>') == false)) die('<strong style="color: #F00">Erreur d\'ouverture / fermeture blockquote dans les images');
		$contentWP = preg_replace('/<blockquote(.*?)>((.|\n)*?)(<\/blockquote>)/i', '<a class="pic-ref" id="texte_img-'.$img.'" name="texte_img-'.$img.'" href="#img-'.$img.'" to="#img-'.$img.'">[Figure '.$img.']</a>', $contentWP, 1);
		$img++;
	}

	/* Générer les notes de bas de page */
/*	$note = 1; /* Numéro de la première note */
/*	preg_match_all('/\{\{(.*?)\}\}/', $contentWP, $notes);
	while (strpos($contentWP, '{{') !== false && strpos($contentWP, '}}') !== false) {

		/*$pos = strpos($contentWP, '{{'); // Obtient la position de cette citation dans le texte

		// Initialise les variables la premières fois
		if (!isset($memoire)) $memoire = $pos;
		if (!isset($memoireCompare)) $memoireCompare = $pos;
		if (!isset($longueur)) $longueur = 0;

		$ecart = ceil((($pos - $memoire)/10) + ($longueur/1.5));

		if ($memoireCompare + ($longueur * 6) < $pos) {
			$ecart = 0;
		}*/
/*		$contentWP = preg_replace(array('/\{\{(.*?)\}\}/'), '<sup>'.$note.'</sup><span class="note" style="margin-top:'.$ecart.'px"><sup>'.$note.'</sup>'.$notes[1][$note-1].'</span>', $contentWP, 1);

		// Défini si la longueur (nb de caractères de la note de bas de page
		/*$longueur = strlen($notes[1][$note-1]);

		$memoire = $pos;
		$memoireCompare = $memoireCompare + ($longueur * 6);*/

/*		$note++;
	}
*/

echo '<div id="article">
  <div id="article-header-container">
    <div id="article-header">
			<div class="icons">
				<div class="resize-container">
					<div class="resize-text">Mode plein écran</div>
					<div class="icon resize"></div>
				</div>
			</div>
		  <h2 class="article-author">'.$tagAuteur.'</h2>
      <h3 class="article-infos">Nr '.$tagRevue.' . '.get_the_date('j F Y')/*$listREVUES[$tagRevue]['date_full']*/.'</h3>
      <h1>
        '.esc_attr(get_the_title()).'
      </h1>
    </div>
  </div>
  <article id="article-content">';
  	echo '<h1 class="article-title">
      '.esc_attr(get_the_title()).'
    </h1>
    <hr class="divider"></hr>
		<div class="icons">
      <div class="resize-container">
        <div class="resize-text">Mode plein écran</div>
        <div class="icon resize"></div>
      </div>
      <div id="zoom">
        <div class="icon plus"></div>
        <div class="letters">
          <span>A</span><span>A</span><span>A</span>
        </div>
        <div class="icon minus"></div>
      </div>
    </div>
    <h2 class="article-author">'.$tagAuteur.'</h2>
    <h3 class="article-infos">Nr '.$tagRevue.' . '.get_the_date('j F Y')/*$listREVUES[$tagRevue]['date_full']*/.'</h3>';
		if (isset($pdf) && trim($pdf) != "") {
	    echo '<a href="'.$pdf.'" id="download-btn">Télécharger le PDF</a>';
	  }
		echo '<div id="article-body">
      <div id="article-summary">';

		/* Parcourir l'article pour récupérer l'ensemble des titres puis créer le menu */
		$contentWP  = preg_replace('/<h1 .*?class="(.*?)">(.*?)<\/h1>/','<h1>$2</h1>', $contentWP);
    	preg_match_all("/<h1>(.*?)<\/h1>/", $contentWP, $h1Titles);

		foreach ($h1Titles['1'] as $h1Title) {
			if(!isset($tableMatieres)) echo '<h1 class="title-light">Table des matières</h1><ul>'; $tableMatieres = 1;
			echo '<li><a href="#'.filter($h1Title).'">'.$h1Title.'</a></li>';
		}



		/* Rajouter les liens ancres dans l'article */
		while (strpos($contentWP, '<h1>') !== false) {
			preg_match("/<h1>(.*?)<\/h1>/", $contentWP, $h1Titles);
			$contentWP = preg_replace("/<h1>(.*?)<\/h1>/", '<h1 name="'.filter($h1Titles[1]).'" id="'.filter($h1Titles[1]).'">'.$h1Titles[1].'</h1>', $contentWP, 1);
		}

    if(isset($tableMatieres)) echo '</ul>';
    echo '</div>';

		echo $contentWP;
		//Guillaume SOULEZ, « Retour à l’envoyeur. », MEI : Information et Mediation #39 [En ligne], mis en ligne le 11 novembre 2016, consulté le 05 juin 2017. URL : http://mei-info.com/revue/39/57/
		echo '<h1 class="title-light">Citer cet article</h1>';
		$quote = $tagAuteur.', « '.esc_attr(get_the_title()).' », [Plastik] : '.$listREVUES[$tagRevue]['titre'].' #'.$tagRevue.' [en ligne], mis en ligne le '.get_the_date('j F Y')/*$listREVUES[$tagRevue]['date_full']*/.', consulté le '.date_fr_txt(date('Y-m-d')).'. URL : '.get_permalink();
		$quote .= $issn != "" ? ' ISSN '.$issn : '';
		echo '<p>'.$quote.'</p>
		<div id="quote">
			<div id="quote-btn">Copier la citation</div>
			<div id="quote-message"></div>
			<input id="quote-input" type="text" value="'.$quote.'" />
		</div>
		</div>
  </article>
  <aside id="article-aside">
		<div id="article-aside-content">';

  /* Afficher : Images */
  if (count($imgs[0]) > 0) {
	  foreach ($imgs[0] as $key => $img) {
		  $num = $key+1;

		  /* Cas exceptionnel pour les nots de bas de page inclus dans une référence */
		  if (is_array($img)) $img = $img[1];

		  /* Repère décalé pour permettre un lien ancre visible au centre de l'écran */
		  // echo '<a id="img-'.$num.'" name="img-'.$num.'" ></a>';

		  // echo '<p style="padding-left:30px; padding-right:15px;"><a href="#" style="font-family: DinMedium; color: #000; cursor:pointer; text-decoration: none; position: relative; top: 1.4em; left: -1.5em;"><!--<a href="#texte_img-'.$num.'" style="font-family: DinMedium; color: #000; cursor:pointer; text-decoration: none; position: relative; top: 1.4em; left: -1.5em;">-->Fig. '.$num.'</a><br>'.$img.'</p>';
			echo '<div class="pic" id="img-'.$num.'">';
			echo $img;
			echo '</div>';
		}

  }
  /* FIN Images */

	/* Afficher : Notes de bas de page */
	if (count($notes[1]) > 0) {
		foreach ($notes[1] as $key => $note){
			$num = $key+1;

			/* Cas exceptionnel pour les nots de bas de page inclus dans une référence */
			if (is_array($note)) $note = $note[1];

			/* Repère décalé pour permettre un lien ancre visible au centre de l'écran */
			echo '<a id="note-'.$num.'" name="note-'.$num.'" ></a>';

			echo '<p style="padding-left:30px; padding-right:15px;"><a href="#" style="font-family: DinMedium; color: #000; cursor:pointer; text-decoration: none; position: relative; top: 1.4em; left: -1.5em;"><!--<a href="#texte_note-'.$num.'" style="font-family: DinMedium; color: #000; cursor:pointer; text-decoration: none; position: relative; top: 1.4em; left: -1.5em;">-->'.$num.'</a><br>'.$note.'</p>';
		}

	}
	/* FIN Notes de bas de page */
  echo '
		<div>
  </aside>
</div>';

$page = 'article';

/* Passage de variable pour le menu */
$GLOBALS['tagRevue'] = $tagRevue;
$GLOBALS['listREVUES'] = $listREVUES;
$GLOBALS['listARTICLES'] = $listARTICLES;
get_footer();
?>
