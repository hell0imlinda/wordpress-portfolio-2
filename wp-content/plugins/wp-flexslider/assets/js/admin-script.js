/**
 * Theme Javascript
 * custom.js
 */
;(function( $ ){

    'use strict';

    var ns = '.wprr-';

    var doSortable = function (list){

        if( list.hasClass('ui-sortable') ){
           list.sortable('refresh'); 
        }else{
            list.sortable();
        }

    }, 
    updateList = function(){

        $( ns + 'rptbl-list li').each(function(){
            var $dat = $(this),
                index = $dat.index();

            $dat.find('[data-name]').each(function(){

                var $input = $(this),
                    newName = $input.data('name');

                $input.attr('name', newName.replace( /__x__/g, index ) );
            })

        });

    },
    updateScore = function(){

        var featuresCount = $( ns + 'feature-point' ).length,
            temp = 0,
            sum = 0,
            score = 0;

        $(ns + 'feature-point').each(function(){
            var $dat = $(this),
            datVal = Number( $('input', $dat).val());

            if ( !isNaN( datVal ) ){
                sum += datVal;
                temp++;
            }
        });

        score = sum/temp;

        if ( !isNaN( score ) ){
            score = score.toFixed(1);
        }else{
            score = 0;
        }
        $(ns + 'score-info').text( score );
        $(ns + 'score').val( score );
    },

    validateField = function(){

        var max = $( ns + 'types-select' ).find('option:selected').data('max');

        $(ns + 'feature-point').each(function(){
            var $dat = $(this),
                $input = $('input', $dat),
                datVal = Number( $input.val());

            if ( isNaN( datVal )
                || ( datVal 
                    && ( datVal < 0 || datVal > Number( max ) ) )
            ){
                $input.addClass('error');
            }else{
                $input.removeClass('error');
            }
        });

    };

    $(document).ready(function(){

        updateList();
        updateScore();
        validateField();

        $(ns+'rptbl-list').sortable({
            handle: '[data-role="move"]',
            sort: function(event, ui){
                ui.placeholder.css({'border': '2px dashed #eee', 'visibility': 'visible'});
            },
            update: function(event, ui){
                updateList();
            }
        });

    }).on( 'click', ns + 'nav li a', function(e){

        e.preventDefault();

        var $el = $(this),
            li = $el.closest('li'),
            tab = li.data('tab'),
            tabNav = $el.closest( ns + 'nav'),
            tabContent = tabNav.siblings( ns + 'content');

        if( li.hasClass('active') )
            return;

        tabNav.find('li').removeClass('active');
        li.addClass('active');
        tabContent.find( ns + 'tab').removeClass('active');
        tabContent.find( ns + 'tab[data-tab="' + tab + '"]').addClass('active');


    }).on( 'click', ns + 'thumb-upload', function(e){

        e.preventDefault();
        
        var mediaUploader;

        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media({
            title: wprr_vars.mediaUploadTitle,
            button: {
                text: wprr_vars.mediaBtnText
            }, 
            multiple: false 
        } );

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
            var atm = mediaUploader.state().get('selection').first().toJSON();
            // console.log(atm);
            if( atm.id ){
                $( ns + 'thumb').val( atm.id );
                $( ns + 'thumb-preview').html('<img src="'+atm.sizes.medium.url+'" width="'+atm.sizes.medium.width+'" height="'+atm.sizes.medium.height+'">');
                $(ns + 'thumb-remove').removeClass('hidden');
            }
            
        });
        // Open the uploader dialog
        mediaUploader.open();

    }).on( 'click', ns + 'thumb-remove', function(e){

        e.preventDefault();
        $( ns + 'thumb').val('' );
        $( ns + 'thumb-preview').html('');
        $(this).addClass('hidden');
        
    }).on( 'click', ns + 'rptbl-controls a', function(e){

        e.preventDefault();

        var $el = $(this),
            role = $el.data('role'),
            list = $(ns+'rptbl-list');

        if( 'delete' === role ){
            $el.closest('li').remove();
            doSortable(list);
            updateList();
            updateScore();
        }


    }).on( 'click', ns + 'rptbl-more', function(e){

        e.preventDefault();

        var $el = $(this),
            template = $el.data('template'),
            list = $el.siblings(ns+'rptbl-list');

        list.append('<li>'+template+'</li>');
        doSortable(list);
        updateList();

    }).on( 'change', ns + 'types-select', function(e){

        validateField();

        e.preventDefault();
        var $dat = $(this),
            $features = $( ns + 'features' );
        $( ns + 'scale-info' ).text($dat.find('option:selected').text());

        if( 'none' === $dat.val() ){
            $features.hide();
        }else{
            if( $features.css('display') == 'none' ){
                // console.log('haha');
                $features.show();
            }
        }

    }).on( 'blur', ns + 'feature-point input', function(){
        
        updateScore();
        validateField();

    }).on('submit', '#post', function(){

        var obj = {},
            $inputs = $('[data-wprr-fields] :input');

        obj = $inputs.serializeObject();

        $('[data-wprr-data]').val( JSON.stringify(obj) );
        $inputs.removeAttr('name');

    });

// Works with either jQuery
})( window.jQuery );

/**
 * serializeObject
 **/
(function($){
    $.fn.serializeObject = function(){

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);