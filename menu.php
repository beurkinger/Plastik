<?php
$page = isset($page) ? $page : '';
 ?>
<nav id="main-menu" class="<?php echo $page; ?>">
  <h1>Plastik</h1>
  <ul>
    <li>
        <a href="index.php" class="inactive">
          A<span>ccuei</span>l
        </a>
    </li>
    <li>
      <a href="search.php" class="inactive">
        R<span>echerch</span>e
      </a>
    </li>
    <li>
      <a href="magazines.php" class="active">
        N<span>uméro</span>s
      </a>
      <?php if ($page === "article") require('./menuArticle.php'); ?>
    </li>
    <li>
      <a href="authors.php" class="inactive">
        A<span>uteur</span>s
      </a>
    </li>
    <li>
      <a href="contribute.php" class="inactive">
        C<span>ontribue</span>r
      </a>
    </li>
    <li>
      <a href="contact.php" class="inactive">
        C<span>ontac</span>t
      </a>
    </li>
  </ul>
</nav>
