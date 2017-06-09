<?php

/* DRESSER LA LISTE DES REVUES en fonction du tag */
function listREVUES($ordre = NULL) {
$listREVUES = array();
	$args  = array(
		'post_type'      => 'revue',
		'posts_per_page' => -1
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_tags = get_the_tags();
			$listREVUES[$post_tags[0]->name]['numero'] = $post_tags[0]->name;
			$listREVUES[$post_tags[0]->name]['titre'] = esc_attr(get_the_title());
			$listREVUES[$post_tags[0]->name]['date'] = get_the_date('Y');
			$listREVUES[$post_tags[0]->name]['date_full'] = get_the_date('j F Y');
			$listREVUES[$post_tags[0]->name]['img_full'] = get_the_post_thumbnail_url( NULL, 'large', NULL );
		}
	}

	if ($ordre == 'reverse') {
		krsort($listREVUES);
	} else {
		ksort($listREVUES);
	}
	return $listREVUES;
}
/* FIN DE DRESSER LA LISTE DES REVUES */

/* DRESSER LA LISTE DES ARTICLES en fonction du tag */
function listARTICLES() {
$listARTICLES = array();
	$args  = array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'orderby'        => 'date',
        'order'          => 'ASC',
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_tags = get_the_tags();

			foreach ($post_tags as $tag) {
				if ($tag->name > 0) {
					$numero = $tag->name;
				}
			}

			if (get_post_meta( get_the_ID(), 'ordre', true ) > 0) {
				$ordre = get_post_meta( get_the_ID(), 'ordre', true );
			} else {
				$ordre = rand(10000, 999999999);
			}

			$edito = get_post_meta( get_the_ID(), 'edito', true );
			if ($edito == 1 || $edito == 'oui') {
				$genre = 'edito';
			} else {
				$genre = 'article';
			}

			$listARTICLES[$numero][$genre][$ordre]['ordre'] = get_post_meta( get_the_ID(), 'ordre', true );
			$listARTICLES[$numero][$genre][$ordre]['id'] = get_the_ID();
			$listARTICLES[$numero][$genre][$ordre]['title'] = esc_attr(get_the_title());
			$listARTICLES[$numero][$genre][$ordre]['date'] = get_the_date('Y');
			$listARTICLES[$numero][$genre][$ordre]['date_full'] = get_the_date('j F Y');
			$listARTICLES[$numero][$genre][$ordre]['ordre'] = get_post_meta( get_the_ID(), 'ordre', true );
			$listARTICLES[$numero][$genre][$ordre]['lien'] = get_permalink();

			foreach ($post_tags as $tag) {
				if ($tag->name > 0) {
					$listARTICLES[$numero][$genre][$ordre]['numero'] = $tag->name;
				} else {
					if(!isset($listARTICLES[$numero][$genre][$ordre]['auteur'])) {
						$listARTICLES[$numero][$genre][$ordre]['auteur'] = $tag->name;
					} else {
						$listARTICLES[$numero][$genre][$ordre]['auteur'] = $listARTICLES[$numero][$genre][$ordre]['auteur'].' et '.$tag->name;
					}
				}
			}

			ksort($listARTICLES[$numero][$genre]);
		}
	}

	return $listARTICLES;
}
/* FIN DE DRESSER LA LISTE DES ARTICLES */

//active les images à la une
add_theme_support('post-thumbnails');


/* Filtrer les caractères spéciaux */
function filter($in) {
   $accents = array('À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ',' !',' ?','!','?',' ','.',',','(',')','²','\'','’',':','"','+','[',']','/','ñ','Ñ','@');
   $sans = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','','','','','-','','','','','2','-','-','','','','','','-','','','a');
   return str_replace($accents, $sans, $in);
}

// Tronquer un texte
function tronquerTxt($txt, $max_caracteres) {
	//nombre de caractères à afficher
	// Test si la longueur du texte dépasse la limite
	if (strlen($txt)>$max_caracteres)
	{
		// Séléction du maximum de caractères
		$txt = substr($txt, 0, $max_caracteres);
		// Récupération de la position du dernier espace (afin déviter de tronquer un mot)
		$position_espace = strrpos($txt, " ");
		$txt = substr($txt, 0, $position_espace);
		// Ajout des "..."
		$txt = $txt."...";
	}
	return $txt;
}

// Sert à formater une date YYYY-MM-JJ au format JJ Mois YYYY
function date_fr_txt($date)
{
	$annee = substr($date,'0','4');
	$mois = substr($date,'5','2');
	$jour = substr($date,'8','2');
	$jour = ($jour == "01") ? "1er" : $jour;

	switch ($mois) {

		case "01" :	$mois = "janvier";		break;
		case "02" :	$mois = "février";		break;
		case "03" :	$mois = "mars";			break;
		case "04" :	$mois = "avril";		break;
		case "05" :	$mois = "mai";			break;
		case "06" :	$mois = "juin";			break;
		case "07" :	$mois = "juillet";		break;
		case "08" :	$mois = "août";			break;
		case "09" :	$mois = "septembre";	break;
		case 10 :	$mois = "octobre";		break;
		case 11 :	$mois = "novembre";		break;
		case 12 :	$mois = "décembre";		break;
	}

	$frdate = "$jour $mois $annee";
return "$frdate";
}


function themeUrl() { return content_url() . '/themes/groehinger-quiros2017'; }
function themeCallImage($img) { return themeUrl() . '/public/css/img/' . $img; }

/*******************************/
// Affiche les arguments de recherche
/*******************************/
function searchDisplayVar($var) {
	$var = str_replace('s=', '', $var);
	$var = str_replace('%20', ' ', $var);
	return $var;
}
?>
