$(document).ready(function() {

    
    //PLACE VERY SIMPLE INITIALIZATION IN HERE
    //PLEASE PLACE ANYTHING OVER 10 LINES IN ITS OWN BOOTSTRAP FILE 
    //TO KEEP THINGS TIDY

    /* Houston, we have javascript */
    // $('html').addClass('js');

    

    $('.genieNav').genieMenu();

    $(document).intraPageLoad({
    	pagesCompatible:function(current_url, target_url){
            var current_domain = getDomain(current_url);
            var target_domain = getDomain(target_url);
            var domainsMatch = current_domain == target_domain;
            var isBlog = target_url.toLowerCase().indexOf('blog') >= 0 || current_url.toLowerCase().indexOf('blog') >= 0;
            var isAdmin = target_url.toLowerCase().indexOf('wp-admin') >= 0;
            var isFile = getPath(target_url).indexOf('.') >= 0;

            // console.log("getPath(target_url): "+getPath(target_url))
            // console.log("current_domain: "+current_domain+" target_domain: "+target_domain)

            // console.log("target_url: "+target_url+" domainsMatch: "+domainsMatch+" getDomain(target_url): "+getDomain(target_url))
            if(domainsMatch==true && isBlog==false && isAdmin==false && isFile==false){
            	return true;
            }
            return false;
    	},
        loadContainerSelector:function(){
        	return '#main';
        },
        targetContainerSelector:function(){
        	return '#main';
        }
    });


    function getDomain(url){
    	var urlParts = url.replace('http://','').replace('https://','').split(/[/?#]/);
        return urlParts[0];
    }
    function getPath(url){
        var urlParts = url.replace('http://','').replace('https://','').split(/[/?#]/);
        urlParts.shift();
        return urlParts.join('/');
    }

    $(document).bind('INTRAPAGELOAD.beginLoading', function(event){
       clearPageContent();
    });
    $(document).bind('INTRAPAGELOAD.loadingComplete', function(event){
       newPageContent();
    });
    $(window).bind('resize', function(event){
       updateScrollPane();
    });
    function clearPageContent(){
        //TODO
    }
    function newPageContent(){
        $(".entry-content").fitVids({ customSelector: "iframe"});      

        addGalleryListeners();

        updateScrollPane();


        setTimeout(function(){
            updateScrollPane();
        }, 100);
        
    }

    var jScrollPaneApi = null;
    function updateScrollPane(){
        var mobileBreakpoint = 768;
        if($('.format-image-and-text').length > 0){

            if(jScrollPaneApi!=null){
                jScrollPaneApi.destroy(); 
                jScrollPaneApi = null;                 
            }

            var text_height = $('.format-image-and-text .text > div').height();
            var image_height = $('.format-image-and-text .image img').height();

            // console.log("image_height: "+image_height)
            
            var longEnough = text_height > (image_height+10);
            var wideEnough = $(window).width() >= mobileBreakpoint;
            if(longEnough && wideEnough){
                $('.format-image-and-text .text').height(image_height);    
                jScrollPaneApi = $('.format-image-and-text .text').jScrollPane().data().jsp                  

                $('.format-image-and-text .text .jspContainer').height(image_height);    
                
            }else{
                $('.format-image-and-text .text').height("auto");    
            }

            $('.format-image-and-text .text').addClass('inited');

        }
    }

    function addGalleryListeners(){
        $('.thumbnails a.gallery_image').bind("click", function(event){
            event.preventDefault();
            var href = $(this).attr("href");
            var target = $(this).attr("data-target");
            $(target).find('img').attr("src", href);
            $(target).find('img').show();
            $(target).find('iframe').hide();
        });
        $('.thumbnails a.gallery_video').bind("click", function(event){
            event.preventDefault();
            var href = $(this).attr("href");
            var target = $(this).attr("data-target");
            var width = $(this).attr("data-width");
            var height = $(this).attr("data-height");
            $(target).find('iframe').attr("src", href);
            $(target).find('iframe').attr("width", width);
            $(target).find('iframe').attr("height", height);

            console.log("width? "+width+" height? "+height)
            $(target).find('img').hide();
            $(target).find('iframe').show();

            $(".entry-content").fitVids({ customSelector: "iframe"});      
        });
    }

    newPageContent();
    
});


