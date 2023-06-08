jQuery( window ).on( 'elementor:init', function() {
	'use strict';

	var $ = jQuery,
		PGS_Ajax_Select_View = elementor.modules.controls.BaseData.extend({
			onReady: function () {
				var self          = this,
					el_wrapper    = self.$el,
					select_el     = self.ui.select,
					control_title = self.ui.controlTitle,
					obj_data      = self.model.attributes,
					el_cid        = self.model.cid,
					current_ids   = ( typeof self.getControlValue() !== 'undefined' ) ? self.getControlValue() : '';

				select_el.select2({
					minimumInputLength: 3,
					ajax: {
						method  : "POST",
						url     : pgs_ajax_select_localize.ajaxurl,
						dataType: 'json',
						data    : function( params ) {
							var query_params = {
								action     :'pgs_ajax_select_autocomplete',
								action_type: 'search',
								term       : params.term,
								nonce      : pgs_ajax_select_localize.nonce,
								param_name : obj_data.name,
								source_name: obj_data.source_name,
								source_type: obj_data.source_type,
								ajax_params: obj_data.ajax_params,
								selected   : select_el.val()
							}
							return query_params;
						},
					},
					cache: true
				});

				var ids = [];
				if ( ! Array.isArray( current_ids ) && current_ids != '' ) {
					ids = [current_ids];
				}else if( Array.isArray( current_ids ) ) {
					ids = current_ids.filter( function( el ) {
						return el != null;
					})
				}

				if ( ids.length > 0 ) {
					control_title.after('<span class="elementor-control-spinner">&nbsp;<i class="eicon-spinner eicon-animation-spin"></i>&nbsp;</span>');
					$.ajax({
						method: "POST",
						url: pgs_ajax_select_localize.ajaxurl,
						data: {
							action     : 'pgs_ajax_select_autocomplete',
							action_type: 'get_titles',
							nonce      : pgs_ajax_select_localize.nonce,
							param_name : obj_data.name,
							source_name: obj_data.source_name,
							source_type: obj_data.source_type,
							ajax_params: obj_data.ajax_params,
							selected   : ids,
						}
					} ).then( function( response ) {
						if ( typeof response.results != 'undefined' && Object.keys( response.results ).length > 0 ) {
							$.each( response.results, function( i, v ) {
								var new_option = new Option(
									v.text,
									v.id,
									true,
									true
								);
								select_el.append( new_option ).trigger( 'change' );
							} );
							select_el.trigger({
								type: 'select2:select',
								params: {
									data: response
								}
							});
						}
						control_title.siblings('.elementor-control-spinner').remove();
					});
				}

				//Manual Sorting : Select2 drag and drop : starts
				// #ToDo Try to use promise in future
				select_el.next().children().children().children().sortable({
					containment: 'parent',
					stop: function(event, ui) {
						ui.item.parent().children('[title]').each(function() {
							var title = $(this).attr('title');
							var original = $('option:contains(' + title + ')', select_el).first();
							original.detach();
							select_el.append(original)
						});
						select_el.change();
					}
				});

				select_el.on("select2:select", function(evt) {
					var element = evt.params.data.element;
					var $element = $(element);

					$element.detach();
					$(this).append($element);
					$(this).trigger("change");
				});
				//Manual Sorting : Select2 drag and drop : ends

			}
		});

	// Add Control Handlers.
	elementor.addControlView( 'pgs_ajax_select', PGS_Ajax_Select_View );
} );
