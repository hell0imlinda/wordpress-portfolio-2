/**
 * WP Flexslider
 *
 * @author mnmlthms
 * @url mnmlthms
 */
;(function( $ ){

    'use strict';

    $(document).ready(function(){

        var $slider = $('.wp-flexslider');

        if( !$slider.length )
            return;

        if( !$.fn.flexslider )
            return;

        $slider.each(function(){
            var $el = $(this),
            settings = $el.data('flex-settings');

            if( settings ){
                $slider.flexslider(settings);
            }

        });

    });

// Works with either jQuery
})( window.jQuery );
