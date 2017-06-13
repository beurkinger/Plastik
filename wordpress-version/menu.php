<?php
if (is_singular('post')) $page = 'article';
?>

<nav id="main-menu" class="<?php echo $page; ?>">
  <h1>Plastik</h1>
  <ul>
    <li>
        <?php $class = is_page('accueil') ? 'active' : 'inactive' ?>
        <a href="/" class="<?php echo $class; ?>">
          A<span>ccuei</span>l
        </a>
    </li>
    <li>
      <?php $class = is_page('la-revue') ? 'active' : 'inactive' ?>
      <a href="/la-revue" class="<?php echo $class; ?>">
        R<span>evu</span>e
      </a>
    </li>
    <li>
      <?php $class = is_page('numeros') || is_singular('post') ? 'active' : 'inactive' ?>
      <a href="/numeros" class="<?php echo $class; ?>">
        N<span>uméro</span>s
      </a>
      <?php if (is_singular('post')) require($themeUrl.'menuArticle.php'); ?>
    </li>
    <li>
      <?php $class = is_page('auteurs') || is_singular('auteur') ? 'active' : 'inactive' ?>
      <a href="/auteurs" class="<?php echo $class; ?>">
        A<span>uteur</span>s
      </a>
    </li>
    <li>
      <?php $class = is_page('contribuer') ? 'active' : 'inactive' ?>
      <a href="/contribuer" class="<?php echo $class; ?>">
        C<span>ontribue</span>r
      </a>
    </li>
    <li>
      <?php $class = is_page('contact') ? 'active' : 'inactive' ?>
      <a href="/contact" class="<?php echo $class; ?>">
        C<span>ontac</span>t
      </a>
    </li>
    <li>
      <a href="/recherche" class="<?php echo $class; ?>">
        <!--
        <img src="<?php echo themeCallImage('search.svg'); ?>" alt="Rechercher un article" class="loupe" />
         -->
      </a>
    </li>
  </ul>
  <div id="main-menu-footer">
    <a href="#">Crédits</a>
    <a href="#">Mentions légales</a>
  </div>
</nav>
