/**
 * Tabs - jQuery plugin for accessible, unobtrusive tabs
 * @requires jQuery v1.1.1
 *
 * http://stilbuero.de/tabs/
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Version: 2.7.4
 */
(function($){
	
	/**
	 * Create an accessible, unobtrusive tab interface based on a particular HTML structure.
	 *
	 * The underlying HTML has to look like this:
	 *
	 * <div id="container">
	 *     <ul>
	 *         <li><a href="#fragment-1">Section 1</a></li>
	 *         <li><a href="#fragment-2">Section 2</a></li>
	 *         <li><a href="#fragment-3">Section 3</a></li>
	 *     </ul>
	 *     <div id="fragment-1">
	 *
	 *     </div>
	 *     <div id="fragment-2">
	 *
	 *     </div>
	 *     <div id="fragment-3">
	 *
	 *     </div>
	 * </div>
	 *
     * @example $('#container').tabs();
	 * @desc Create a basic tab interface.
	 **/
    var defaults = {
        event: 'click',
        selectedClass: 'current-tab',
        hideClass: 'hidden'  
    };
	/**
	  * @type jQuery
      *
      * @name tabs
      * @cat Plugins/Tabs
      * @author Klaus Hartl/klaus.hartl@stilbuero.de
      **/
    $.fn.tabs = function(o){
        var o = $.extend(defaults, o), $tabs=null, panels=[];
        
        var $tabs = $('a:first-child', this);   
        $tabs.each(function(){
            var hash = this.hash && this.hash.substr(1);
            panels.push(hash);
        });  
        if (panels.length == 0) return false;
        
        //bind behaviors
        $tabs.unbind(o.event)
            .bind(o.event, function(){
				//移出
                $tabs.hasClass(o.selectedClass) && $tabs.removeClass(o.selectedClass);
				//添加当前
                $(this).addClass(o.selectedClass);
				
                var pid = this.hash && this.hash.substr(1);
                for(var i = 0; i < panels.length; i++){
                    if (panels[i] == pid){
                        $('#'+ panels[i]).removeClass(o.hideClass);
                    }else{
                        $('#'+ panels[i]).addClass(o.hideClass);
                    }                    
                }

				this.blur();
                return false;
            });
    };
})(jQuery);