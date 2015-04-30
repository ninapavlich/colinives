/*!
 * nina@ninalp.com
 */


;(function ( $, window, document, undefined ) {



    // Create the defaults once
    var pluginName = "intraPageLoad",
        defaults = {
            loadingClass: "loading",
            pagesCompatible:null,
            loadContainerSelector:null,
            targetContainerSelector:null,
            loadContainerID: "intraPageLoadContainer",
            initedClass:'intraPageLoadInited'
        };

    // The actual plugin constructor
    function IntraPageLoad( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;
        this.loadContainer = $("<div>").hide(0);
        $(this.loadContainer).attr("id", this.options.intraPageLoadContainer);

        this._defaults = defaults;
        this._name = pluginName;

        this.current_url = null;

        if(this.options.pagesCompatible==null){
            this.options.pagesCompatible = this.arePagesCompatible
        }
        if(this.options.loadContainerSelector==null){
            this.options.loadContainerSelector = this.getLoadContainerSelector
        }
        if(this.options.targetContainerSelector==null){
            this.options.targetContainerSelector = this.getTargetContainerSelector
        }
        
        this.init();
    }

    IntraPageLoad.prototype = {

        init: function() {
            
            this.current_url = window.location.href;
            this.addListeners()
          

            this.render()
        },
        setProperty: function() {
          this.render()
        },
        arePagesCompatible: function(current_url, target_url){
            return false;
        },
        getLoadContainerSelector:function(){
            //return selector
            return 'body';
        },
        getTargetContainerSelector:function(){
            //return selector
            return 'body';
        },
        contentLoaded: function(){

        },
        render: function() {
            //Update view
        },
        onLinkClick: function(e, target_href){
            
            var self = this;
            var isNewURL = target_href != self.current_url;

            if(isNewURL){

                // console.log("render: "+target_href+" from "+self.current_url+" isNewURL? "+isNewURL)
                var supportsHistory = Modernizr.history;
                if(supportsHistory){

                    var compatible = this.options.pagesCompatible(window.location.href, target_href);
                    if(compatible){

                        self.current_url = target_href;

                        if(e!=null){
                            e.preventDefault();    
                        }                    

                        $('body').trigger('INTRAPAGELOAD.beginLoading');
                        var loadContainerSelector = this.options.loadContainerSelector();
                        var loadContainer = $(loadContainerSelector);
                        $(loadContainer).addClass(this.options.loadingClass);

                        var target_selector = this.options.targetContainerSelector();
                        var load_selector = target_href+" "+target_selector;

                        $( loadContainerSelector ).load( load_selector, function() {     

                            
                            if(e!=null){
                                history.pushState(null, null, target_href);                   
                            }                            
                            $(loadContainer).removeClass(self.options.loadingClass);
                            $('body').trigger('INTRAPAGELOAD.loadingComplete');
                            self.addLinkListeners(); 
                        });
                    }
                }
            }else{
                if(e!=null){
                    e.preventDefault();    
                } 
            }
            
            
            
        },
        addListeners: function() {
            //bind events
            var self = this;
            this.addLinkListeners();
            window.addEventListener("popstate", function(e) {
                // console.log('popstate: '+location.href+" "+self.current_url);
                
                if(location.href != self.current_url){
                    self.onLinkClick(null, location.href);    
                }                
            });
        },
        addLinkListeners:function(){
            var self = this;
            $("a").not("."+this.options.initedClass).each(function( index, link ) {
                $(link).addClass(self.options.initedClass);
                $(link).bind("click", function(e){
                    self.onLinkClick(e, $(this).attr('href'));
                });
            });
        },

        removeListeners: function() {
            //unbind events           
        }

    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new IntraPageLoad( this, options ));
            }
        });
    };

})( jQuery, window, document );

//$( document ).ready(function() {
//  $(".selector").pluginName();
//});


