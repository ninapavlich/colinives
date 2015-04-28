<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
echo "<pre>";
print_r($post);
echo "</pre>";
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/VisualArtwork">
	<header class="entry-header">
		<h1 class="entry-title">
			<span class="project-title">
				<span class="project-name" itemprop="name"><?= $post->project_name ?></span>
				<span class="subproject-name"><?= $post->display_title ?></span>
			</span>
		</h1>
	</header>


	<div class="entry-content" itemscope itemtype="https://schema.org/ImageGallery">
        <div class="format-image-gallery">
            <div class="full">
                <div class="gallery_image_full"></div>
            </div>


            <ul class="thumbnails">
            	
            	<li>
            		gallery_elements
            		<img src="<?= $post->image_source ?>" alt="<?= $post->image_title ?>" itemprop="image" class="cols_3">
            	</li>
            </ul>
        </div>
    </div>

</article><!-- #post-## -->
