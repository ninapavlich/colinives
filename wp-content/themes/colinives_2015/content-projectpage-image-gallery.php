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


	<div class="entry-content" itemscope itemtype="https://schema.org/ImageGallery">
        <div class="format-image-gallery">
            <div class="full">

                <img class="gallery_image_full" src="<?= $post->gallery_elements[0]['full_image'] ?>" />
                
            </div>


            <ul class="thumbnails">

                <?php foreach($post->gallery_elements as $gallery_element): ?>

                <li>
                    <a href="<?= $gallery_element['full_image'] ?>" data-target=".full" class="gallery">
                        <img src="<?= $gallery_element['thumbnail_image'] ?>" alt="<?= $gallery_element['full_image_title'] ?>"  />
                    </a>
                </li>
                
                <?php endforeach; ?>
            	
            </ul>
        </div>
    </div>

</article><!-- #post-## -->
