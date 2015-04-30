$(document).ready(function() {

    
    //PLACE VERY SIMPLE INITIALIZATION IN HERE
    //PLEASE PLACE ANYTHING OVER 10 LINES IN ITS OWN BOOTSTRAP FILE 
    //TO KEEP THINGS TIDY

    /* Houston, we have javascript */
    // $('html').addClass('js');

    

    $('.genieNav').genieMenu();

    $(document).intraPageLoad({
    	pagesCompatible:function(current_url, target_url){
            var domainsMatch = getDomain(current_url) == getDomain(target_url)
            var isBlog = target_url.toLowerCase().indexOf('blog') >= 0 || current_url.toLowerCase().indexOf('blog') >= 0;
            var isAdmin = target_url.toLowerCase().indexOf('wp-admin') >= 0;

            console.log("target_url: "+target_url)
            if(domainsMatch==true && isBlog==false && isAdmin==false){
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
		var domain = urlParts[0];
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
            
            var longEnough = text_height > (image_height+10);
            var wideEnough = $(window).width() >= mobileBreakpoint;
            if(longEnough && wideEnough){
                $('.format-image-and-text .text').height(image_height);    
                jScrollPaneApi = $('.format-image-and-text .text').jScrollPane().data().jsp                  
            }else{
                $('.format-image-and-text .text').height("auto");    
            }

            $('.format-image-and-text .text').addClass('inited');

        }
    }

    newPageContent();
    
});


