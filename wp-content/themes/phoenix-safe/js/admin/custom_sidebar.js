/* Custom sidebar */
(function ($) {
    var CustomSidebar = function () {
        this.widget_wrap = $('.widget-liquid-right');
        this.widget_area = $('#widgets-right');
        this.ciyashop_add_del_button();
        this.ciyashop_bind_events();
    };
    CustomSidebar.prototype = {
        ciyashop_add_del_button: function () {
            this.widget_area.find('.sidebar-ciyashop-custom').append('<i class=" ciyashop-delete dashicons dashicons-dismiss"></i>');
        },
        ciyashop_bind_events: function () {
            this.widget_wrap.on('click', '.sidebar-ciyashop-custom .ciyashop-delete', $.proxy(this.ciyashop_delete_sidebar, this));
        },
        ciyashop_delete_sidebar: function (e) {
            var widget = $(e.currentTarget).parents('.widgets-holder-wrap:eq(0)'),
                    title = widget.find('.sidebar-name h2'),
                    spinner = title.find('.spinner'),
                    widget_name = $.trim(title.text()),
                    widget_id = $.trim(widget.children('div').attr('id')),
                    obj = this;
            if (confirm(ciyashop_sidebar_strings.delete_sidebar_confirm)) {
                $.ajax({
                    type: "POST",
                    url: window.ajaxurl,
                    data: {
                        action: 'ciyashop_delete_sidebar_area',
						dataType: "json",
                        name: widget_name,
                        widget_id: widget_id,
                        _wpnonce: ciyashop_sidebar_strings.sidebar_nonce
                    },
                    beforeSend: function () {
                        spinner.addClass('activate_spinner');
                    },
                    success: function (data) {
						data = JSON.parse(data);
						responce = data['result'];
						if ( responce == true) {
							widget.slideUp(200, function () {
                                $('.widget-control-remove', widget).trigger('click');
                                widget.remove();
                                wpWidgets.saveOrder();
                            });
                        } else if ( responce == false) {
                            spinner.removeClass('activate_spinner');
                            alert(ciyashop_sidebar_strings.delete_sidebar_msg);
                        }
                    }
                });
            }
        }
    };
    $(function () {
        new CustomSidebar();
    });
})(jQuery);
