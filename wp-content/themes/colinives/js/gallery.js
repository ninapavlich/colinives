$(document).ready(function() {
	
	$(".thumbnails > img").each(function() {
		var thumbnail_id = $(this).attr('id');
		var raw_id = thumbnail_id.substr(10);
		$(this).click(function() {
			showGalleryElement(raw_id);
		});		
	});
	
	
	
	showGalleryElement(1);
	
	//get all img tags in class thumbnails
});


	function showGalleryElement(id){
		$(".full > div.gallery_image_full").each(function() {
			var full_id = $(this).attr('id');
			var raw_id = full_id.substr(5);
			
			if( id == raw_id){
				$(this).fadeIn(600);	
			}else{
				$(this).fadeOut(200);	
			}
			
			
		});
	}