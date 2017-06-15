<?php
/* Template Name: Accueil */

/* Obtenir la liste des articles */
$listARTICLES = listARTICLES();

/* Obtenir la liste des revues */
$listREVUES = listREVUES('reverse');

get_header();

?>

</head>
<body>

<?php
// Liste les numéros disponibles dans le menu
foreach ($listREVUES as $key => $revue) {

	  echo '
	  <div class="mag" style="background: url(\''.$revue['img_full'].'\') center center / cover no-repeat fixed;">
		<div class="mag-content">
		  <div class="boxes-container mag-boxes" style="margin-left: '.rand(0, 20).'%; margin-top: '.rand(0, 25).'%;">';

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

			echo '<div class="box number-box">
			  <h4>Nr</h4>
			  <h2>'.$revue['numero'].'</h2>
			</div>
			<div class="box center offset infos-box">
			  <h3>'.$revue['titre'].'</h3>
			</div>
			</a>
		  </div>
		</div>
	  </div>';

}

get_footer();

?>
