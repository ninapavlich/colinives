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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Person">
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
				<ul class="urls">
					<?php foreach($post->url_elements as $url_element): ?>

	                <li>
	                    <a href="<?= $url_element['website_url'] ?>" title="<?= $url_element['website_name'] ?>" itemprop="sameAs">
	                        <?php if($url_element['website_icon_class']): ?>
	                        	<i class="fa fa-<?= $url_element['website_icon_class'] ?>"></i>
	                    	<?php else: ?>
	                    		<?= $url_element['website_name'] ?>
	                    	<?php endif ?>
	                    </a>
	                </li>	                
	                <?php endforeach; ?>
	            </ul>
			</div>
			<div class="text">
				<div itemprop="description">
					<?= $post->description ?>
				</div>
			</div>
		</div>				
	</div>

</article><!-- #post-## -->
