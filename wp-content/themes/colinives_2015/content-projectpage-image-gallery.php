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

                <?php if($post->gallery_elements[0]['vimeo_video_id']): ?>
                
                <iframe class="gallery_video_full" frameborder="0" width="<?= $post->gallery_elements[0]['vimeo_embed_width']; ?>" height="<?= $post->gallery_elements[0]['vimeo_embed_height']; ?>" src="http://player.vimeo.com/video/<?= $post->gallery_elements[0]['vimeo_video_id']; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" ></iframe>
                <img class="gallery_image_full" src="" style="display:none;" />
                
                <?php else: ?>

                <iframe class="gallery_video_full" style="display:none;" />
                <img class="gallery_image_full" src="<?= $post->gallery_elements[0]['full_image'] ?>" />
                
                <?php endif ?>

                
            </div>


            <ul class="thumbnails">

                <?php foreach($post->gallery_elements as $gallery_element): ?>

                <li>
                    <?php if($gallery_element['vimeo_video_id']): ?>
                    <a href="http://player.vimeo.com/video/<?= $gallery_element['vimeo_video_id']; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" data-target=".full" data-width="<?= $gallery_element['vimeo_embed_width']; ?>" data-height="<?= $gallery_element['vimeo_embed_height']; ?>" class="gallery_video">
                    <?php else: ?>
                    <a href="<?= $gallery_element['full_image'] ?>" data-target=".full" class="gallery">
                    <?php endif ?>

                        <img src="<?= $gallery_element['thumbnail_image'] ?>" alt="<?= $gallery_element['full_image_title'] ?>"  />
                    </a>
                </li>
                
                <?php endforeach; ?>
            	
            </ul>
        </div>
    </div>

</article><!-- #post-## -->
