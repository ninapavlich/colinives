<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<?php $theme_dir = get_template_directory_uri(); ?>
	<link rel="apple-touch-icon" sizes="57x57" href="<?=$theme_dir ?>/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?=$theme_dir ?>/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?=$theme_dir ?>/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?=$theme_dir ?>/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?=$theme_dir ?>/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?=$theme_dir ?>/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?=$theme_dir ?>/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?=$theme_dir ?>/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?=$theme_dir ?>/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="<?=$theme_dir ?>/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?=$theme_dir ?>/favicons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="<?=$theme_dir ?>/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?=$theme_dir ?>/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?=$theme_dir ?>/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="<?=$theme_dir ?>/favicons/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">

</head>

<body <?php body_class(); ?>>

<?php

	$project_menu = getProjectMenuItems();

	// echo "<pre>";
	// print_r($project_menu);
	// echo "</pre>";

?>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<nav>
			<ul>
				
				<?php foreach($project_menu as $project): ?>


				<?php $first_project = $project->projects[0] ?>


				<pre>
				<?= print_r($project->projects) ?>
			</pre>

				<?php if($first_project): ?>
				<li>
					<a href="">
						<figure>
							<figcaption><?= $project->name ?></figcaption>
							<img src="<?= $first_project->image_source ?>" alt="<?= $first_project->image_title ?>" itemprop="image" />
						</figure>
					</a>
				</li>
				<?php endif ?>
				<?php endforeach; ?>
			</ul>
		</nav>

	</header>



	<div id="content" class="site-content">
