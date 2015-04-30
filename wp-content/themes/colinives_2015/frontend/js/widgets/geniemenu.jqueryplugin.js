/*!
 * nina@ninalp.com
 */

;(function ( $, window, document, undefined ) {

   

    // Create the defaults once
    var pluginName = "genieMenu",
        defaults = {
            resizeInterval: 100,
            maxMenuSlideMargin: 0,
            mouseDetectRegionY: 225
        };

    // The actual plugin constructor
    function GenieMenu( element, options ) {
        this.element = element;

       
        this.options = $.extend( {}, defaults, options) ;

        this.menuButtons = [];
        this.mouseX;
        this.mouseY;

        this.window_focus = true;
        this.xmultiplier = 0;

        this.menuoffset = 0;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    GenieMenu.prototype = {

        init: function() {

            var self = this;
            var runningW = 30;
            $(this.element).find('li').each(function(){        
                self.menuButtons.push($(this));                
                runningW += $(this).outerWidth();
            });
            $(this.element).find('ul').css("width", runningW);
           
            this.addListeners();

            this.render();

            setTimeout(function(){
                $(self.element).addClass('inited');
            },1000)
            
        },
       

        render: function() {
            //This funciton is expensive, so only do it when menu is active and has focus
            if(this.window_focus==false) return;

            //Update view
            this.updateMenuButtons();
        },

        updateMousePosition: function(e){
            this.mouseX = e.pageX;
            this.mouseY = e.pageY;


            var window_width = $(window).width();

            var left_portion = 0.2 * window_width;
            var right_portion = 0.8 * window_width;
            var top_section = this.options.mouseDetectRegionY;
            if(this.mouseX <= left_portion && this.mouseY < top_section){
                //mouse is on left side of screen
                var strength_left = 1 - (this.mouseX / left_portion); //how close the the left edge are you

                var speed = 30 * strength_left;

                this.xmultiplier = this.xmultiplier + ((speed-this.xmultiplier)/5);

                
            }else if(this.mouseX >= right_portion && this.mouseY < top_section){
                var strength_right = ((this.mouseX-right_portion) / left_portion); //how close the the left edge are you
                var speed = -30 * strength_right;
                //mouse is on right side of screen
                this.xmultiplier = this.xmultiplier + ((speed-this.xmultiplier)/5);

            }else{
                //mouse is below active region
                this.xmultiplier = this.xmultiplier + (0-this.xmultiplier)/6;
                if( Math.abs(this.xmultiplier)<1) {
                    this.xmultiplier = 0;
                }   
            }
            
            // console.log("xmultiplier: "+this.xmultiplier)
            this.onFocus(); //if we're receiving mouse events, turn focus on

        },
        updateMenuButtons: function(){
            
            //update size of buttons
            for(var k = 0; k<this.menuButtons.length; k++){
                var button = this.menuButtons[k];                
                var distance = this.calculateDistance(button, this.mouseX, this.mouseY);
                var scale = this.distanceToScale(distance);
                this.animateMenuButton(button, scale, 0);
            }


            //center the menu container
            var window_width = $(window).width();
            menu_width = $(this.element).find('ul').width();
            // console.log("window_width: "+window_width+" menu_width: "+menu_width)
    
            var xvalue = 0.5 * (window_width - menu_width);
            

            // console.log("this.menuoffset: "+this.menuoffset)
            xvalue = (xvalue + this.menuoffset);



            if(menu_width > window_width){
                var min_x = (window_width-menu_width) - this.options.maxMenuSlideMargin;
                var max_x = this.options.maxMenuSlideMargin;    
            }else{
                var min_x = max_x = 0.5 * (window_width - menu_width);
            }
            

            // console.log("min_x: "+min_x+" max_x: "+max_x)
            xvalue = Math.max(min_x, xvalue);
            xvalue = Math.min(max_x, xvalue);

            if(xvalue==max_x && this.xmultiplier>0){
                //at threshold, don't increase
            }else if(xvalue==min_x && this.xmultiplier<0){
                //at threshold, don't decrease
            }else{
                this.menuoffset += this.xmultiplier;
            }
                        
            $(this.element).find('ul').css('marginLeft', xvalue + 'px');

        },
        animateMenuButton: function(item, scale, duration){
            origin_y = '95px'; //TODO -- calculate
            origin_x = '50%';
            this.scaleItem(item.find('figure').get(0), scale, origin_x, origin_y);
        },
        distanceToScale: function(distance){
            var min_threshold = 40;
            var max_threshold = 300;
            var min_scale = .05;
            
            var dist_bottom = Math.max(0, distance - min_threshold);
            var portion = Math.min(1, dist_bottom / max_threshold);
            var reverse = Math.max(min_scale, 1 - portion);
            //console.log("dist = "+distance+" dist_bottom = "+dist_bottom+" portion = "+portion+" reverse = "+reverse);
            return reverse;
            
        },
        calculateDistance: function(elem, mouseX, mouseY) {
            //x distance
            //return Math.abs(mouseX - (elem.offset().left+(elem.width()/2)));
            
            //actual distance
            return Math.floor(Math.sqrt(Math.pow(mouseX - (elem.offset().left+(elem.width()/2)), 2) + Math.pow(mouseY - (elem.offset().top+(elem.height()/2)), 2)));
        },
        onFocus:function(){
            this.window_focus = true;
        },
        onBlur:function(){
            this.window_focus = false;
        },
        addListeners: function() {
            //bind events
            var self = this;

            $(document).mousemove(function(e) { 
                self.updateMousePosition(e);
            });

            $(window).focus(function() {  self.onFocus(); });
            $(window).blur(function() { self.onBlur(); });

            setInterval(function(){
                self.render();
            }, this.options.resizeInterval);
        },

        removeListeners: function() {
            //unbind events           
        },
        scaleItem: function(element, scale, origin_x, origin_y){
            var origin = origin_x+' '+origin_y;
            $(element).css('-webkit-transform-origin', origin);
            $(element).css('-moz-transform-origin', origin);
            $(element).css('-o-transform-origin', origin);
            $(element).css('-ms-transform-origin', origin);
            $(element).css('transform-origin', origin);

            var scaler = 'scale('+scale+')';
            $(element).css('-webkit-transform', scaler);
            $(element).css('-moz-transform', scaler);
            $(element).css('-o-transform', scaler);
            $(element).css('-ms-transform', scaler);
            $(element).css('transform', scaler);
        }


    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new GenieMenu( this, options ));
            }
        });
    };

})( jQuery, window, document );

//$( document ).ready(function() {
//  $(".selector").pluginName();
//});


