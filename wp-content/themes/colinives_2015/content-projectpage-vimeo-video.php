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
			<span class="project-title">
				<span class="project-name" itemprop="name"><?= $post->project_name ?></span>
				<span class="subproject-name"><?= $post->display_title ?></span>
			</span>
		</h1>
	</header>


	 <div class="entry-content" itemprop="video" itemscope itemtype="https://schema.org/VideoObject">
        <div class="format-vimeo-video">
            <div class="vimeo" >
  				<meta itemprop="embedURL" content="http://player.vimeo.com/video/<?= $post->vimeo_id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" />
                <iframe frameborder="0" height="350" src="http://player.vimeo.com/video/<?= $post->vimeo_id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="467"></iframe>
            </div>
        </div>
    </div>

</article><!-- #post-## -->
