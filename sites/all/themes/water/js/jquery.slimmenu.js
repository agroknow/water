/**
 * jquery.slimmenu.js
 * http://adnantopal.github.io/slimmenu/
 * Author: @adnantopal
 * Copyright 2013, Adnan Topal (atopal.com)
 * Licensed under the MIT license.
 */
;(function ( $, window, document, undefined )
{
    var pluginName = "slimmenu",
        defaults =
        {
            resizeWidth: '768',
            collapserTitle: 'Main Menu',
            animSpeed: 'medium',
            easingEffect: null,
            indentChildren: false,
            childrenIndenter: '&nbsp;&nbsp;'
        };

    function Plugin( element, options )
    {
        this.element = element;
        this.$elem = $(this.element);
        this.options = $.extend( {}, defaults, options );
        this.init();
    }

    Plugin.prototype = {

        init: function()
        {
            var $options = this.options,
                $menu = this.$elem,
                $collapser = '<div class="menu-collapser">'+$options.collapserTitle+'<div class="collapse-button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></div>',
                $menu_collapser;

            $menu.before($collapser);
            $menu_collapser = $menu.prev('.menu-collapser');

            $menu.on('click', '.sub-collapser', function(e)
            {
                e.preventDefault();
                e.stopPropagation();

                var $parent_li = $(this).closest('li');
                var $parent_nav = $(this).closest('nav');
                
                if($parent_nav.hasClass('fixed')){
                    $parent_nav.find('.sub-collapser').not($(this)).removeClass('expanded');
                    $parent_nav.find('i').html('&#9660;');
                    $parent_nav.find('>ul li ul').slideUp($options.animSpeed, $options.easingEffect);
                }

                if ($(this).hasClass('expanded'))
                {
                    $(this).removeClass('expanded');
                    $(this).find('i').html('&#9660;');
                    $parent_li.find('>ul').slideUp($options.animSpeed, $options.easingEffect, function(){
                    checkScroll($parent_nav);
                });
                }
                else
                {
                    $(this).addClass('expanded');
                    $(this).find('i').html('&#9650;');
                    $parent_li.find('>ul').slideDown($options.animSpeed, $options.easingEffect, function(){
                    checkScroll($parent_nav);
                });
                }
            });
            $menu.on('click', '.subtrigger', function(e)
            {
                e.preventDefault();
                e.stopPropagation();
                
                var $curr_subcollapser = $(this).siblings('.sub-collapser');
                var $parent_li = $(this).closest('li');
                var $parent_nav = $(this).closest('nav');
                
                if($parent_nav.hasClass('fixed')){
                    $parent_nav.find('.sub-collapser').not($curr_subcollapser).removeClass('expanded');
                    $parent_nav.find('i').html('&#9660;');
                    $parent_nav.find('>ul li ul').slideUp($options.animSpeed, $options.easingEffect);
                }

                if ($curr_subcollapser.hasClass('expanded'))
                {
                    $curr_subcollapser.removeClass('expanded');
                    $curr_subcollapser.find('i').html('&#9660;');
                    $parent_li.find('>ul').slideUp($options.animSpeed, $options.easingEffect, function(){
                    checkScroll($parent_nav);
                });
                }
                else
                {
                    $curr_subcollapser.addClass('expanded');
                    $curr_subcollapser.find('i').html('&#9650;');
                    $parent_li.find('>ul').slideDown($options.animSpeed, $options.easingEffect, function(){
                    checkScroll($parent_nav);
                });
                }
            });

            $menu_collapser.on('click', '.collapse-button', function(e)
            {
                e.preventDefault();
                $menu.slideToggle($options.animSpeed, $options.easingEffect, function(){
                    checkScroll($menu.parent());
                });
            });

            this.resizeMenu({ data: { el: this.element, options: this.options } });
            $(window).on('resize', { el: this.element, options: this.options }, this.resizeMenu);
            
            function checkScroll($navb)
            {   
                if( $navb.height() > $(window).height())
                {
                    $navb.css({"overflow-y":"scroll","bottom":"0"});
                } else {
                    $navb.css({"overflow-y":"hidden","bottom":"auto"});
                }
            }
        },

        resizeMenu: function(event)
        {
            var $window = $(window),
                $options = event.data.options,
                $menu = $(event.data.el),
                $menu_collapser = $('body').find('.menu-collapser');

            $menu.find('li').each(function()
            {
                if ($(this).has('ul').length)
                {
                    if ($(this).has('.sub-collapser').length)
                    {
                        $(this).children('.sub-collapser i').html('&#9660;');
                    }
                    else
                    {
                        $(this).append('<span class="sub-collapser"><i>&#9660;</i></span>');
                    }
                }

                //$(this).children('ul').hide();
                $(this).find('.sub-collapser').removeClass('expanded').children('i').html('&#9660;');
            });

            if ($options.resizeWidth >= $window.width())
            {
                if ($options.indentChildren)
                {
                    $menu.find('ul').each(function()
                    {
                        var $depth = $(this).parents('ul').length;
                        if (!$(this).children('li').children('a').has('i').length)
                        {
                            $(this).children('li').children('a').prepend(Plugin.prototype.indent($depth, $options));
                        }
                    });
                }

                $menu.find('li').has('ul').off('mouseenter mouseleave');
                $menu.addClass('collapsed').hide();
                $menu_collapser.show();
            }
            else
            {
//                $menu.find('li').has('ul').on('mouseenter', function()
//                {
//                    $(this).find('>ul').stop().slideDown($options.animSpeed, $options.easingEffect);
//                })
//                .on('mouseleave', function()
//                {
//                    $(this).find('>ul').stop().slideUp($options.animSpeed, $options.easingEffect);
//                });

                $menu.find('li > a > i').remove();
                $menu.removeClass('collapsed').show();
                $menu_collapser.hide();
            }
        },

        indent: function(num, options)
        {
            var $indent = '';
            for (var i=0; i < num; i++)
            {
                $indent += options.childrenIndenter;
            }
            return '<i>'+$indent+'</i>';
        }
    };

    $.fn[pluginName] = function ( options )
    {
        return this.each(function ()
        {
            if (!$.data(this, "plugin_" + pluginName))
            {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );