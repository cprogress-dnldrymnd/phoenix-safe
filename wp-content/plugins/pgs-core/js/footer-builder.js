(function($){
	"use strict";
		
	$( document ).ready(
		function() {

				// Append Columns settings
				AppendColumns();

				// Sidebar drag and drop functionality
				ElemnetDragDrop();

				// Form field dependency
				FormDataDependency();

				// Form field hide show for tabs
				FieldsActionHideShow();

				// Footer column slider for number of columns.
				var handle = $( '#footer-columns-slider-handle' );
				$( '#pgsfb-footer-columns-slider' ).slider(
					{
						max: 12,
						value: $( '#pgsfb-footer-columns' ).val(),
						create: function() {
							handle.text( $( this ).slider( 'value' ) );
						},
						slide: function( event, ui ) {
							handle.text( ui.value );
							$( '#pgsfb-footer-columns' ).val( ui.value );

							AppendColumns();
							ElemnetDragDrop();
						}
					}
				);

				// Save the footer builder.
				$( document ).on(
					'click',
					'.pgsfb-save',
					function( event ) {
						event.preventDefault();

						var footer_title = $( '.layout-title' ).val();
						var footer_id    = $( this ).data( 'footer_id' );

						if ( ! footer_title ) {
							  $( '.layout-title' ).addClass( 'pgsfb-required' );
							$( 'html, body' ).animate(
								{
									scrollTop: $( '.layout-title' ).offset().top - 100
								},
								1000
							);

							  return;
						} else {
							  $( '.layout-title' ).removeClass( 'pgsfb-required' );
						}

						$( '.pgsfb-footer-column-setting:hidden' ).remove();

						$( '#wpwrap' ).append( '<div class="pgsfb-overlay"></div>' );
						var footer_data = $( 'form#pgsfb-footer-settings' ).serializeArray();
						var footer_text_left = tinymce.get( 'footer_text_left' ).getContent();
						var footer_text_right = tinymce.get( 'footer_text_right' ).getContent();
						var footer_bottom_content = tinymce.get( 'footer_bottom_content' ).getContent();

						for ( var index = 0; index < footer_data.length; ++index) {
							if ( footer_data[index].name == 'footer_settings[common_settings][footer_text_left]' ) {
								footer_data[index].value = footer_text_left;
							}
							if ( footer_data[index].name == 'footer_settings[common_settings][footer_text_right]' ) {
								footer_data[index].value = footer_text_right;
							}
							if ( footer_data[index].name == 'footer_settings[common_settings][footer_bottom_content]' ) {
								footer_data[index].value = footer_bottom_content;
							}
						}

						footer_data.push(
							{ name: 'action', value: 'save_footer_builder' },
							{ name: 'footer_settings[footer_id]',  value: footer_id  }
						);

						$.ajax(
							{
								type: 'POST',
								url: ajaxurl,
								dataType: 'json',
								encode : true,
								data:  footer_data,
								success: function( response ) {
									  $( '.pgsfb-overlay' ).remove();
									if ( response.redirect ) {
										var url = $( location ).attr( 'href' );
										url    += '&footer_id=' + response.footer_id;
										$( location ).attr( 'href',url );
									}
								}
							}
						);
					}
				);

				// Clone Footer
				$( document ).on(
					'click',
					'.footer-layout-clone',
					function(e){
						e.preventDefault();

						var $footer_id = $( this ).data( 'footer_id' );

						if ( ! $footer_id ) {
							  return;
						}

						$.ajax(
							{
								type: 'POST',
								url: ajaxurl,
								data: { action: 'clone_footer', footerId: $footer_id },
								dataType: 'json',
								success: function( response ) {

									var length = $( 'ul.footer-layout-lists li' ).length;
									length     = length - 1;

									var footerLocation = $( location );
									var href           = footerLocation.attr( 'protocol' ) + '//' + footerLocation.attr( 'host' ) + footerLocation.attr( 'pathname' );

									$( 'ul.footer-layout-lists > li:eq(' + length + ')' ).after( '<li class="footer-layout-list-item"><div class="footer-layout-list-item-inner"><a href="' + href + '?page=footer-layout&footer_id=' + response.footer_id + '">' + response.footer_title + '</a><div class="footer-layout-list-actions"><a href="' + href + '?page=footer-layout&footer_id=' + response.footer_id + '" class="footer-layout-action footer-layout-edit"><span class="dashicons dashicons-edit"></span></a><a href="' + href + '?page=footer-layout&footer_id=' + response.footer_id + '" class="footer-layout-action footer-layout-clone" data-footer_id="' + response.footer_id + '"><span class="dashicons dashicons-admin-page"></span></a><a href="' + href + '?page=footer-layout&footer_id=' + response.footer_id + '" class="footer-layout-action footer-layout-delete" data-footer_id="' + response.footer_id + '"><span class="dashicons dashicons-trash"></span></a></div></li>' );
								}
							}
						);
					}
				);

				// Delete Footer
				$( document ).on(
					'click',
					'.footer-layout-delete',
					function(e){
						e.preventDefault();

						var $footer_id = $( this ).data( 'footer_id' ),
						$this          = $( this );
						if ( ! $footer_id ) {
							  return;
						}

						if ( confirm( cfl.delete_footer_layout ) ) {
							$.ajax(
								{
									type: 'POST',
									url: ajaxurl,
									data: { action: 'delete_footer', footerId: $footer_id },
									dataType: 'json',
									success: function( response ) {
										$this.parents( 'li' ).remove();
									}
								}
							);
						}
					}
				);

				// Delete Element
				$( document ).on(
					'click',
					'.pgsfb-element-content .pgsfb-remove-btn',
					function() {
						if ( confirm( cfl.delete_element ) ) {
							  $( this ).parents( '.pgsfb-element-column' ).find( 'input.pgsfb-element-column-input' ).val( '' );
							  $( this ).parents( '.pgsfb-element-droppable' ).addClass( 'pgsfb-droppable-active' );
							  $( this ).parents( '.pgsfb-draggable-item' ).remove();
							  ElemnetDragDrop();
						}
					}
				);

				// Active tab for form
				$( document ).on(
					'click',
					'.pgsfb-edit-tabs .pgsfb-tabs-title',
					function() {

						if ($( this ).hasClass( 'pgsfb-tab-active' )) {
							  return;
						}

						$( '.pgsfb-edit-tabs .pgsfb-tabs-title' ).removeClass( 'pgsfb-tab-active' );
						$( this ).addClass( 'pgsfb-tab-active' );
						FieldsActionHideShow();
					}
				);

				// Remove the background image values.
				$( document ).on(
					'click',
					'.pgsfb-remove-media-button',
					function() {
						var $this = $( this ).parents( '.pgsfb-background-setting-field' );
						$this.find( '.pgsfb-field-media-id' ).val( '' );
						$this.find( '.pgsfb-field-media-src' ).val( '' );
						$this.find( '.pgsfb-field-media-cover img' ).attr( 'src' , '' );
						$this.find( '.pgsfb-field-media-cover' ).addClass( 'hidden' );
						$( this ).addClass( 'hidden' );
					}
				);

				var mediaUpload;

				// Media upload for background image.
				$( document ).on(
					'click',
					'.media-upload',
					function ( event ) {
						event.preventDefault();

						var $this = $( this ).parents( '.pgsfb-background-setting-field' );

						// If the uploader object has already been created, reopen the dialog
						if ( mediaUpload ) {
							  mediaUpload.open();
							  return;
						}

						// Extend the wp.media object
						mediaUpload = wp.media.frames.file_frame = wp.media(
							{
								title: cfl.choose_image,
								button: {
									text: cfl.choose_image,
									close: true
								},
								multiple: false
							}
						);

						// When a file is selected, grab the URL and set it as the text field's value
						mediaUpload.on(
							'select',
							function() {
								var attachment = mediaUpload.state().get( 'selection' ).first().toJSON();
								$this.find( '.pgsfb-field-media-id' ).val( attachment.id );
								$this.find( '.pgsfb-field-media-src' ).val( attachment.url );
								$this.find( '.pgsfb-field-media-cover img' ).attr( 'src' , attachment.url );
								$this.find( '.pgsfb-field-media-cover' ).removeClass( 'hidden' );
								$this.find( '.pgsfb-remove-media-button' ).removeClass( 'hidden' );
							}
						);

						// Open the uploader dialog
						mediaUpload.open();
					}
				);

				// Color picker for form fields
				$( '.color-picker' ).wpColorPicker();

				// Close the footer settings
				$( document ).on(
					'click',
					'.pgsfb-footer-configure, .pgsfb-element-settings-close',
					function() {
						if ( $( '.pgsfb-elements-settings' ).hasClass( 'pgsfb-elements-settings-show' ) ) {
							  $( '.pgsfb-elements-settings' ).removeClass( 'pgsfb-elements-settings-show' );
						} else {
							  $( '.pgsfb-elements-settings' ).addClass( 'pgsfb-elements-settings-show' );
						}
					}
				);

				// Close the footer save settings
				$( document ).on(
					'click',
					'.pgsfb-save-configuration',
					function( event ) {
						if ( $( '.pgsfb-elements-settings' ).hasClass( 'pgsfb-elements-settings-show' ) ) {
							  $( '.pgsfb-elements-settings' ).removeClass( 'pgsfb-elements-settings-show' );
						}
					}
				);

				// Open the footer settings
				$( document ).on(
					'click',
					'.pgsfb-close-element',
					function( event ) {
						document.getElementById( 'pgsfb-footer-settings' ).reset();
						if ( $( '.pgsfb-elements-settings' ).hasClass( 'pgsfb-elements-settings-show' ) ) {
							  $( '.pgsfb-elements-settings' ).removeClass( 'pgsfb-elements-settings-show' );
						}
					}
				);

				// Form field dependency on change of field value
				$( document ).on(
					'click',
					'.pgsfb-field-input',
					function() {
						var value      = $( this ).val();
						var param_name = $( this ).attr( 'name' );
						var $data_tab  = $( '.pgsfb-edit-tabs .pgsfb-tabs-title.pgsfb-tab-active' ).data( 'tab' );

						$( '[data-dependency-element="' + param_name + '"]' ).each(
							function(){
								var dependency     = $( this ).data( 'dependency-value' );
								var dependency_tab = $( this ).data( 'content' );

								if ($.inArray( value, dependency ) == -1) {
									$( this ).hide();
								} else {
									if ( dependency_tab == $data_tab ) {
										$( this ).show();
									}
								}
							}
						);
					}
				);
		}
	);

	// Function to append the column
	function AppendColumns(){
		var avl_elements = $( '.pgsfb-footer-column-setting' ).length;
		var vbl_elements = $( '.pgsfb-footer-column-setting:visible' ).length;
		var req_elements = $( '#pgsfb-footer-columns' ).val();
		var i;

		if ( req_elements > avl_elements ) {
			var nd_el = req_elements - avl_elements;
			for ( i = 0; i < nd_el; ++i ) {
				var template     = $( '#pgsfb-column-settings-template' ).html();
				var column_index = $( '.pgsfb-footer-column-setting:visible' ).length + 1;
				var new_template = template.replace( /{{column_index}}/g, column_index );
				$( '.pgsfb-footer-column-settings' ).append( new_template );
			}
		} else {
			if ( req_elements < vbl_elements ) {
				var rmv_el = vbl_elements - req_elements;
				for ( i = 0; i < rmv_el; ++i ) {
					$( '.pgsfb-footer-column-setting:visible' ).last().hide();
				}
			} else if ( req_elements > vbl_elements ) {
				var sw_el = req_elements - vbl_elements;
				for ( i = 0; i < sw_el; ++i ) {
					$( '.pgsfb-footer-column-setting:hidden' ).first().show();
				}
			}
		}
	}

	// Function for drag and drop functionality
	function ElemnetDragDrop(){
		$( '.pgsfb-elements-list .pgsfb-draggable-item' ).draggable(
			{
				scroll: false,
				cursor: 'move',
				opacity: 0.7,
				stack: '.pgsfb-draggable-item',
				helper: 'clone',
			}
		);

		$( '.pgsfb-droppable-active.pgsfb-element-droppable' ).droppable(
			{
				accept: '.pgsfb-elements-list .pgsfb-draggable-item',
				drop: function(event, ui) {
					var droppable = $( this );
					var draggable = ui.draggable;
					var elementId = ui.draggable.find( '.pgsfb-element-content' ).data( 'element_id' );

					if ( droppable.hasClass( 'pgsfb-droppable-active' ) ) {
						droppable.find( '.pgsfb-element-column-input' ).val( elementId );
						draggable.clone().appendTo( droppable );
						droppable.removeClass( 'pgsfb-droppable-active' );

						// Destroy the droppable
						droppable.droppable( 'destroy' );
					}
				}
			}
		);
	}

	// Function to hide show the field based on tab value
	function FieldsActionHideShow() {
		$( '.pgsfb-field-option' ).each(
			function(){

				var $data_tab = $( '.pgsfb-edit-tabs .pgsfb-tabs-title.pgsfb-tab-active' ).data( 'tab' );

				if ($( this ).data( 'content' ) == $data_tab) {
					$( this ).show();
				} else {
					$( this ).hide();
				}
			}
		);
		FormDataDependency();
	}

	// Function for form field dependency
	function FormDataDependency(){

		$( 'form#pgsfb-footer-settings :input' ).each(
			function(){
				if ( this.checked ) {
					var value      = $( this ).val();
					var param_name = $( this ).attr( 'name' );
					var $data_tab  = $( '.pgsfb-edit-tabs .pgsfb-tabs-title.pgsfb-tab-active' ).data( 'tab' );

					$( '[data-dependency-element="' + param_name + '"]' ).each(
						function(){

							var dependency     = $( this ).data( 'dependency-value' );
							var dependency_tab = $( this ).data( 'content' );

							if ($.inArray( value, dependency ) == -1) {
								$( this ).hide();
							} else {
								if ( dependency_tab == $data_tab ) {
									$( this ).show();
								}
							}
						}
					);
				}
			}
		);
	}

})( jQuery );
