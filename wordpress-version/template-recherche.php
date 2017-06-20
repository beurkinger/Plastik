<?php
/**
 * Template Name: Recherche
 */
get_header();
?>
<div id="search">
  <div class="content">
    <article>
      <form action="<?php echo site_url(); ?>/recherche" method="get">
        <input type="text" name="s" id="s" class="search-input" placeholder="Rechercher"/>
        <button type="submit" class="search-btn"></button>
        <div class="search-empty"></div>
      </form>
      <h2 class="search-content">
        Résultats de la recherche avec le terme "animaux"
      </h2>
      <a class="result">
        <h3 class="result-title">
          <em>Self-animalité,</em>
          Marion Laval-Jeannet,
          <strong>Plastik Nr 2</strong>
        </h3>
        <p class="result-content">
          Il y a une dizaine d'années, dans Being There, Andy Clark soulignait à quel point il est tentant pour le sens commun de considérer le cerveau comme un « alien » (un étranger) introduit dans une enveloppe de chair. [...]
        </p>
        <p class="result-date">
          3 juin 2011
        </p>
      </a>
      <a class="result">
        <h3 class="result-title">
          <em>Self-animalité,</em>
          Marion Laval-Jeannet,
          <strong>Plastik Nr 2</strong>
        </h3>
        <p class="result-content">
          Il y a une dizaine d'années, dans Being There, Andy Clark soulignait à quel point il est tentant pour le sens commun de considérer le cerveau comme un « alien » (un étranger) introduit dans une enveloppe de chair. [...]
        </p>
        <p class="result-date">
          3 juin 2011
        </p>
      </a>
    </article>
  </div>
</div>
<?php
get_footer();
?>