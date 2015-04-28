<?php
header("Content-type: text/javascript");

define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
require('../../../../wp-blog-header.php');


$posts = getGroupProjects();
$posts_hashed = array();
$projects_ids = array();
foreach($posts as $post){
	$posts_hashed[$post->post_name] = $post;
	$project_group_slug = trim($post->project_group_slug);
	$projects_ids[$project_group_slug] = array();
}

foreach($posts as $post){
	$project_group_slug = trim($post->project_group_slug);
	array_push($projects_ids[$project_group_slug], $post->post_name);	
}


?>

var current_project_id = '';
var current_subproject_id = '';
var project_ids = <?php echo json_encode($projects_ids); ?>; 
var post_items = <?php echo json_encode($posts_hashed); ?>;

$(document).ready(function() {
	initContent();
});

function initContent(){
	$(window).bind( 'hashchange', function(e) {
		onHashTagChange(e);
	});

	onHashTagChange(null)
	$('#primary').fadeIn();
	$('footer#colophon').fadeIn();

}


function onHashTagChange(e){
	var raw_hash = location.hash;

	if(!raw_hash || raw_hash=='' || raw_hash === undefined) return;

	var hash = raw_hash.split("#")[1]
	var pieces = hash.split("/")
	var project_id = pieces[1];
	var subproject_id = pieces[2];

	log("project_id: "+project_id+" subproject_id "+subproject_id)

	if(!project_id || project_id=='' || project_id===undefined) {
		log("WARNING: Project id is not defined. Ignore hash change");
	}
	if(!subproject_id || subproject_id==''|| subproject_id===undefined){
		log("WARNING: Subproject id is not defined. Redirecting to first subproject.");
		if( project_ids[project_id] !== undefined){
			subproject_id = project_ids[project_id][0];	
			navigateTo("./#/"+project_id+"/"+subproject_id);
			return;
		}else{
			log("WARNING: No subprojects defined for project.");
			return;
		}
		
	} 

	var changeProject = project_id != current_project_id;
	log("Load project: "+project_id+" subproject_id: "+subproject_id+" chane project: "+changeProject);

	loadProject(project_id);
	
	loadSubproject(subproject_id, changeProject);
}
function loadSubproject(subproject_id, changeProject){
	if(current_subproject_id== subproject_id) return;

	if(changeProject){

		$('#primary').fadeOut(300, function(){
			current_subproject_id = subproject_id;
			createPost(post_items[current_subproject_id]);
			populateSubMenu();
			document.title = post_items[current_subproject_id].project_name+" | Colin Ives";
			
			$('#primary').fadeIn();
			$('footer#colophon').fadeIn();


			setTimeout(function(){
				try{
					initScrollPanes();			
				}catch(e){}			
			}, 100)
			

		});
		$('footer#colophon').fadeOut(300);


	}else{
		$('.entry-content').fadeOut(300, function(){
			current_subproject_id = subproject_id;
			createPost(post_items[current_subproject_id]);
			populateSubMenu();

			log("update subproject: "+current_subproject_id)

			$('.entry-content').fadeIn();
			$('.subproject-name').fadeIn();


			setTimeout(function(){
				try{
					initScrollPanes();			
				}catch(e){}			
			}, 100)
			

		});
		$('.subproject-name').fadeOut(300);
	}
	
	

}
function loadProject(project_id){
	if(current_project_id == project_id) return;
	current_project_id = project_id;
	log("update subproject: "+current_project_id)
}


function createPost(post_item){
	var html = '';
	switch(post_item.layout_type){
		case 'image-and-text':
			html = createImageAndTextPost(post_item);
		break;
		case 'image-gallery':
			html = createImageGallery(post_item);
		break;
		case 'vimeo-video':
			html = createVimeoVideo(post_item);
		break;
		default:
			html = createUnknownLayout(post_item);
		break;
	}
	$("#content").html(html);

}
function navigateTo(url){
	window.location = url;
}
function createUnknownLayout(post_item){
	return '<article id="post-'+post_item.id+'">'+		
		'<header class="entry-header">'
			'<h1 class="entry-title"><span class="project-title"><span class="project-name">'+post_item.project_name+'</span><span class="subproject-name">'+post_item.display_title+'</span></span></h1>'+
		'</header><!-- .entry-header -->'+
		'<div class="entry-content">'+
			'<div class="format-image-and-text">'+
				'<div class="image"></div>'+
				'<div class="text">TEXT<div class="scroll-pane"></div></div>'+
			'</div>'+
		'</div><!-- .entry-content -->'+		
		'<footer class="entry-meta">'+
		'</footer><!-- .entry-meta -->'+
	'</article><!-- #post -->';
}
function createImageAndTextPost(post_item){
	return '<link type="text/css" href="wp-content/themes/colinives/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />'+
	'<script type="text/javascript" src="wp-content/themes/colinives/js/jquery.mousewheel.js"></script><!-- the mousewheel plugin - optional to provide mousewheel support -->'+
	'<script type="text/javascript" src="wp-content/themes/colinives/js/jquery.jscrollpane.min.js"></script><!-- the jScrollPane script -->'+
	'<script type="text/javascript" src="wp-content/themes/colinives/js/scrollpane.js"></script><!-- the jScrollPane script -->'+
	'<!-- /SCRIPTS FOR FANCY SCROLL BAR -->'+
	'<article id="post-'+post_item.id+'">'+	
		'<header class="entry-header">'+
			'<h1 class="entry-title"><span class="project-title"><span class="project-name">'+post_item.project_name+'</span><span class="subproject-name">'+post_item.display_title+'</span></span></h1>'+
		'</header><!-- .entry-header -->'+
		'<div class="entry-content">'+
			'<div class="format-image-and-text">'+
				'<div class="image"><img src="'+post_item.image_source+'" alt="'+post_item.image_title+'" /></div>'+
				'<div class="text"><div class="scroll-pane">'+post_item.description+'</div></div>'+
			'</div>'+
		'</div><!-- .entry-content -->'+
		'<footer class="entry-meta">'+
		'</footer><!-- .entry-meta -->'+
	'</article><!-- #post -->';

}
function createImageGallery(post_item){
	return '<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/gallery.js"></script>'+	
	'<article id="post-'+post_item.id+'" >'+
		'<header class="entry-header">'+
			'<h1 class="entry-title"><span class="project-title"><span class="project-name">'+post_item.project_name+'</span><span class="subproject-name">'+post_item.display_title+'</span></span></h1>'+
		'</header><!-- .entry-header -->'+
		'<div class="entry-content">'+
			'<div class="format-image-gallery">'+
				'<div class="full">'+createGalleryElementFull(post_item)+'</div>'+
				'<div class="thumbnails">'+createGalleryThumbnails(post_item)+'</div>'+
			'</div>'+
		'</div><!-- .entry-content -->'+
		'<footer class="entry-meta">'+
		'</footer><!-- .entry-meta -->'+
	'</article><!-- #post -->';

}
function createGalleryElementFull(post_item){
	
	var len = post_item.gallery_elements.length;
	var image_class = len <= 2? 'cols_1' : (len <= 4? 'cols_2' : ( len <= 9? 'cols_3' : 'cols_4' ));
	var output = '';
	for (var k = 0; k < len; k++) {
		
		var gallery_element = post_item.gallery_elements[k];
		if(gallery_element.image_or_video == 'Image'){
			output += '<div class="gallery_image_full" id="full_'+k+'"><img src="'+gallery_element.full_image+'" alt="'+gallery_element.full_image_title+'" /></div>';	
		}else{
			output += '<div class="gallery_image_full '+gallery_element.vimeo_video_id+'" id="full_'+k+'"><iframe src="http://player.vimeo.com/video/'+gallery_element.vimeo_video_id+'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="'+gallery_element.vimeo_embed_width+'" height="'+gallery_element.vimeo_embed_height+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
		}
		
		
	}
	return output;
}
function createGalleryThumbnails(post_item){
	var len = post_item.gallery_elements.length;
	var image_class = len <= 2? 'cols_1' : (len <= 4? 'cols_2' : ( len <= 9? 'cols_3' : 'cols_4' ));
	var output = '';
	for (var k = 0; k < len; k++) {
			
		var gallery_element = post_item.gallery_elements[k];
		output += '<img src="'+gallery_element.thumbnail_image+'" alt="'+gallery_element.thumbnail_title+'" id="thumbnail_'+k+'" class="'+image_class+'" />';
		
	}
	return output;
}

function createVimeoVideo(post_item){
	return '<script type="text/javascript" src="wp-content/themes/colinives/js/swfobject.v2.2.js"></script>'+
	'<article id="post-'+post_item.id+'" >'+
		'<header class="entry-header">'+
			'<h1 class="entry-title"><span class="project-title"><span class="project-name">'+post_item.project_name+'</span><span class="subproject-name">'+post_item.display_title+'</span></span></h1>'+
		'</header><!-- .entry-header -->'+
		'<div class="entry-content">'+
			'<div class="format-vimeo-video">'+
				'<div class="vimeo" style="width:'+post_item.embed_width+'px;height:'+post_item.embed_height+'px">'+
					'<iframe src="http://player.vimeo.com/video/'+post_item.vimeo_id+'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="'+post_item.embed_width+'" height="'+post_item.embed_height+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'+
				'</div>'+
			'</div>'+
		'</div>'+
		'<footer class="entry-meta">'+
		'</footer><!-- .entry-meta -->'+
	'</article><!-- #post -->';

}


function populateSubMenu(){
	$(".colinives-submenu ul").html('');

	var project_items = project_ids[current_project_id];
	for (var k=0; k<project_items.length; k++){
		var subproject_id = project_items[k];
		var post_item = post_items[subproject_id];
		$(".colinives-submenu ul").append(createSubMenuLabel(current_project_id, post_item));
	}


}
function createSubMenuLabel(project_id, subproject){
	log("SLUG: "+subproject.post_name+" current_subproject_id: "+current_subproject_id)
	if(current_subproject_id == subproject.post_name){
		return '<li>'+subproject.display_title+'</li>';	
	}else{
		return '<li><a href="./#/'+project_id+'/'+subproject.post_name+'">'+subproject.display_title+'</a></li>';
	}
	
}
