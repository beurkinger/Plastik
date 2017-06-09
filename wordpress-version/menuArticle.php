<?php
$listREVUES = $GLOBALS['listREVUES'];
$listARTICLES = $GLOBALS['listARTICLES'];
$tagRevue = $GLOBALS['tagRevue'];
$id = get_the_ID();

echo '
<div class="numbers-browser">
  <div class="numbers-list">';

// Liste les numéros disponibles dans le menu
foreach ($listREVUES as $key => $revue) {

	// Créer le lien vers ces numéros
	if (isset($listARTICLES[$key]['edito'])) {
		$tabArticle = reset($listARTICLES[$key]['edito']);
	} else {
		$tabArticle = reset($listARTICLES[$key]['article']);
	}
		echo '<a href="'.$tabArticle['lien'].'" class="number';
    if($key == $tagRevue) echo ' active';
  	echo '">
        '.ltrim($key, "0").'
      </a>';
}
echo '</div>
  <div class="number-content">
    <div class="previous"></div>
      <div class="summary">';

// Liste les editos dans le menu
if (isset($listARTICLES[$tagRevue]['edito'])) {

	echo '<h3>
			Editorial
		  </h3>';

	foreach ($listARTICLES[$tagRevue]['edito'] as $edito) {
      $class = $id == $edito['id'] ? 'active' : '';
      echo '<p class="'.$class.'">
        <a href="'.$edito['lien'].'">'.$edito['title'].'</a>
        <span>'.$edito['auteur'].'</span>
      </p>';
	}
}

// Liste les articles dans le menu
if (isset($listARTICLES[$tagRevue]['article'])) {

	echo '<h3>
			Articles
		  </h3>';

	foreach ($listARTICLES[$tagRevue]['article'] as $article) {
      $class = $id == $article['id'] ? 'active' : '';
      echo '<p class="'.$class.'">
        <a href="'.$article['lien'].'">'.$article['title'].'</a>
        <span>'.$article['auteur'].'</span>
      </p>';
	}
}
echo '
    </div>
    <div class="next"></div>
  </div>
</div>';
