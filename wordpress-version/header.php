<?php /* wp header.php modifié */

$sMetaDescription = get_post_meta(109, 'google', true); // Toujours prendre la méta description de l'accueil par défaut

if (is_home() || is_page('accueil')) { /*** homepage avec plusieurs articles ou home.php ***/
 $sTitle .= get_bloginfo('name');
} else if (is_single() || is_page()) { /*** un seul article (complet) ou une page (y compris l'éventuelle home statique) ***/

 if (!($sTitle = get_post_meta((int)$post->ID, 'title', true))) { // seo title champ personnalisé
 $sTitle = wp_title('', false);
 $sTitle .= ' > '.get_bloginfo('name'); //*Le nom du site en fin de title non SEO (à commenter ou non)
 }

} else { /*** tout le reste (catégories, archives, search, etc.) ***/

 $sTitle = wp_title('', false);
 $sTitle .= ' > '.get_bloginfo('name');

}

  if (get_post_meta((int)$post->ID, 'google', true) != "") {
	$sMetaDescription = get_post_meta((int)$post->ID, 'google', true);
  }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=690, initial-scale=1">

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo themeCallImage('ico/apple-icon-57x57.png'); ?>">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo themeCallImage('ico/apple-icon-60x60.png'); ?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo themeCallImage('ico/apple-icon-72x72.png'); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo themeCallImage('ico/apple-icon-76x76.png'); ?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo themeCallImage('ico/apple-icon-114x114.png'); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo themeCallImage('ico/apple-icon-120x120.png'); ?>">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo themeCallImage('ico/apple-icon-144x144.png'); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo themeCallImage('ico/apple-icon-152x152.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo themeCallImage('ico/apple-icon-180x180.png'); ?>">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo themeCallImage('ico/android-icon-192x192.png'); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo themeCallImage('ico/favicon-32x32.png'); ?>">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo themeCallImage('ico/favicon-96x96.png'); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo themeCallImage('ico/favicon-16x16.png'); ?>">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<link rel="shortcut icon" href="<?php echo themeCallImage('ico/cp.ico'); ?>" type="image/x-icon"/>
<link rel="icon" href="<?php echo themeCallImage('ico/cp.ico'); ?>" type="image/x-icon"/>

<title><?php echo trim($sTitle); ?></title>
<?php
if (is_search() || (is_archive() && !(is_category()))) {
  echo '<meta name="robots" content="noindex" />'.PHP_EOL;
 } else if (!empty($sMetaDescription)) {
  echo '<meta name="description" content="'.$sMetaDescription.'" />'.PHP_EOL;
 }
wp_head(); 
?>

<link rel="stylesheet" type="text/css" href="<?php echo themeUrl() ?>/public/css/style.css">


</head>

<body>
    <main id="main-container">