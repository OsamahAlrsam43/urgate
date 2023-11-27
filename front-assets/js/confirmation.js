
(function( $ ) {

    if (!$.fn.popover) throw new Error('Confirmation requires popover.js');

    // Plugin definition.
    $.fn.confirmation = function(options) {
        var defaults = {
            animation: true,
            container: false,
            content: '<div class="btn-group">'+
                        '<a class="btn btn-success btn-xs" data-confirmation="confirm"><i class="glyphicon glyphicon-ok"></i> Yes</a>'+
                        '<a class="btn btn-danger btn-xs" data-confirmation="cancel"><i class="glyphicon glyphicon-remove"></i> No</a>'+
                     '</div>',
            delay: 0,
            html: true,
            selector: false,
            viewport: {selector: 'body', padding: 0},
            placement: 'top',
            title: 'Are you sure?',
            template: '<div class="popover confirmation">' +
                        '<div class="arrow"></div>' +
                        '<h3 class="popover-title"></h3>' +
                        '<div class="popover-content text-center">'+
                        '</div>'+
                     '</div>',
            onShow : function() {},    // This event fires immediately when the show instance method is called.
            onShown : function() {},   // This event is fired when the popover has been made visible to the user (will wait for CSS transitions to complete).
            onCancel: function() {},   // This event is fired immediately when the user cancel the confirmation
            onConfirm: function() {},  // This event is fired immediately when the user confirm the confirmation
            onHide: function() {},     // This event is fired immediately when the hide instance method has been called.
            onHidden: function() {},   // This event is fired when the popover has finished being hidden from the user (will wait for CSS transitions to complete).
            onInserted: function() {}  // This event is fired after the show.bs.popover event when the popover template has been added to the DOM.
        };
     
        return this.each(function() {
            var settings = $.extend({}, defaults, options);
            var element = $(this);

            // Init the bootstraps popover to the element
            $(this).attr('data-toggle', 'popover');
            $(this).attr('data-trigger', 'focus');
            $(this).popover({
                animation: settings.animation,
                container: settings.container,
                html: settings.html,
                delay: settings.delay,
                placement: settings.placement,
                content: settings.content,
                title: settings.title,
                viewport: settings.viewport,
                selector: settings.selector,
                template: settings.template
            });

            // Catch onShow
            $(this).on('show.bs.popover', function(){
                settings.onShow.call();
            });

            // Catch onShown
            $(this).on('shown.bs.popover', function(){
                settings.onShown.call();

                by = element.attr('aria-describedby');

                // Catch onCancel 
                $('#'+by).find($('[data-confirmation="cancel"]')).on('click', function(){
                    settings.onCancel.call();
                });

                // Catch onConfirm 
                $('#'+by).find($('[data-confirmation="confirm"]')).on('click', function(){
                    settings.onConfirm.call();

                    // Determinate if it is a href attribute set
                    if (element.attr('href') && element.attr('href') != '#') {
                        var href = element.attr('href');
                        var target = element.attr('target') || '_self';

                        // If so, redirect to the link after onConfirm even fired
                        window.open(href, target);
                    }
                });
            });

            // Catch onHide
            $(this).on('hide.bs.popover', function(){
                settings.onHide.call();
            });

            // Catch onHidden
            $(this).on('hidden.bs.popover', function(){
                settings.onHidden.call();
            });

            // Catch onInserted
            $(this).on('inserted.bs.popover', function(){
                settings.onInserted.call();
            });
        });
    };
})( jQuery );
