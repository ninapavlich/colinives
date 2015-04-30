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
        <div class="format-video-gallery">
            <div class="full">
                <iframe class="gallery_video_full" frameborder="0" width="<?= $post->gallery_elements[0]['vimeo_embed_width']; ?>" height="<?= $post->gallery_elements[0]['vimeo_embed_height']; ?>" src="http://player.vimeo.com/video/<?= $post->gallery_elements[0]['vimeo_video_id']; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" ></iframe>
            </div>


            <ul class="thumbnails">

                <?php foreach($post->gallery_elements as $gallery_element): ?>

                <li>
                    <a href="http://player.vimeo.com/video/<?= $gallery_element['vimeo_video_id']; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" data-target=".full" data-width="<?= $gallery_element['vimeo_embed_width']; ?>" data-height="<?= $gallery_element['vimeo_embed_height']; ?>" class="gallery_video">

                        <img src="<?= $gallery_element['thumbnail_image'] ?>" alt="<?= $gallery_element['full_image_title'] ?>"  />
                    </a>
                </li>
                
                <?php endforeach; ?>
            	
            </ul>
        </div>
    </div>

</article><!-- #post-## -->
