<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
// echo "<pre>";
// print_r($post);
// echo "</pre>";
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/VisualArtwork">
	<header class="entry-header">
		<h1 class="entry-title">
			<span class="project-name" itemprop="name"><?= $post->project_name ?></span>
            <span class="subproject-name"><?= $post->display_title ?></span>
		</h1>
	</header>
	<div class="entry-content">
		<div class="format-image-and-text">
			<div class="image">
				<img src="<?= $post->image_source ?>" alt="<?= $post->image_title ?>" itemprop="image">
			</div>
			<div class="text">
				<div itemprop="description">
					<?= $post->description ?>
				</div>
			</div>
		</div>				
	</div>

</article><!-- #post-## -->
