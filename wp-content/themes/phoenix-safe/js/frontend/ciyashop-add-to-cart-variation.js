/*global wc_add_to_cart_variation_params */
;(function ( $, window, document, undefined ) {
	$(document).ready(function($) {

	if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
		$( '.variations_form' ).each( function() {
			var $form = $( this );
			$( this ).on( 'found_variation', function ( event, variation ) {
				$form.ciyashop_wc_variations_image_update( variation );
			} );
		});
	}

	/**
	 * Sets product images for the chosen variation
	 */
	$.fn.ciyashop_wc_variations_image_update = function( variation ) {
		var $form                  = this,
			$product               = $form.closest( '.product' ),
			$product_gallery       = $product.find( '.ciyashop-product-gallery' ),
			$product_gallery_dummy = $product.find( '.images' ),
			$gallery_nav           = $product.find( '.ciyashop-product-thumbnails .slick-track' ),
			$gallery_nav_img       = $gallery_nav.find( 'li:eq(0) img' ),
			$gallery_nav_img_wrap  = $gallery_nav.find( '.slick-slide:eq(0) .ciyashop-product-thumbnail__image' ),
			$product_img_wrap      = $product_gallery
				.find( '.ciyashop-product-gallery__image, .ciyashop-product-gallery__image--placeholder' )
				.eq( 0 ),
			$product_img      = $product_img_wrap.find( 'a img' ),
			$product_link     = $product_img_wrap.find( 'a' ).eq( 0 );

		if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
			// See if the gallery has an image with the same original src as the image we want to switch to.
			var gallery_nav_variation_image_wrap = $gallery_nav.find( '.ciyashop-product-thumbnail__image[data-image_id="' + variation.image_id + '"]' );
			var gallery_nav_has_image = gallery_nav_variation_image_wrap.length > 0;

			// If the gallery has the image, reset the images. We'll scroll to the correct one.
			if ( gallery_nav_has_image ) {
				// $form.ciyashop_wc_variations_image_reset();
			}

			// See if gallery has a matching image we can slide to.
			var slideToImage = gallery_nav_variation_image_wrap.find( 'img' );

			if ( slideToImage.length > 0 ) {
				slideToImage.trigger( 'click' );
				$form.attr( 'current-image', variation.image_id );
				window.setTimeout( function() {
					$( window ).trigger( 'resize' );
					$product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
				}, 20 );
				return;
			}

			$product_img.wc_set_variation_attr( 'src', variation.image.src );

			$product_img.wc_set_variation_attr( 'height', variation.image.src_h );
			$product_img.wc_set_variation_attr( 'width', variation.image.src_w );
			$product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
			$product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
			$product_img.wc_set_variation_attr( 'title', variation.image.title );
			$product_img.wc_set_variation_attr( 'data-caption', variation.image.caption );
			$product_img.wc_set_variation_attr( 'alt', variation.image.alt );
			$product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
			$product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
			$product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
			$product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
			$product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.src );
			$gallery_nav_img.wc_set_variation_attr( 'src', variation.image.gallery_thumbnail_src );
			$product_link.wc_set_variation_attr( 'href', variation.image.full_src );

			$gallery_nav_img_wrap.wc_set_variation_attr( 'data-o_image_id', variation.image_id );
		} else {
			$form.ciyashop_wc_variations_image_reset();
		}

	}

	/**
	 * Reset main image to defaults.
	 */
	$.fn.ciyashop_wc_variations_image_reset = function() {
		var $form                 = this,
			$product              = $form.closest( '.product' ),
			$product_gallery      = $product.find( '.images' ),
			$gallery_nav          = $product.find( '.ciyashop-product-thumbnails .slick-track' ),
			$gallery_nav_img      = $gallery_nav.find( '.slick-slide:eq(0) img' ),
			$gallery_nav_img_wrap = $gallery_nav.find( '.slick-slide:eq(0) .ciyashop-product-thumbnail__image' ),
			$product_img_wrap     = $product_gallery
				.find( '.ciyashop-product-gallery__image, .ciyashop-product-gallery__image--placeholder' )
				.eq( 0 ),
			$product_img      = $product_img_wrap.find( 'a img' ),
			$product_link     = $product_img_wrap.find( 'a' ).eq( 0 );

		$product_img.wc_reset_variation_attr( 'src' );
		$product_img.wc_reset_variation_attr( 'width' );
		$product_img.wc_reset_variation_attr( 'height' );
		$product_img.wc_reset_variation_attr( 'srcset' );
		$product_img.wc_reset_variation_attr( 'sizes' );
		$product_img.wc_reset_variation_attr( 'title' );
		$product_img.wc_reset_variation_attr( 'data-caption' );
		$product_img.wc_reset_variation_attr( 'alt' );
		$product_img.wc_reset_variation_attr( 'data-src' );
		$product_img.wc_reset_variation_attr( 'data-large_image' );
		$product_img.wc_reset_variation_attr( 'data-large_image_width' );
		$product_img.wc_reset_variation_attr( 'data-large_image_height' );
		$product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
		$gallery_nav_img.wc_reset_variation_attr( 'src' );
		$product_link.wc_reset_variation_attr( 'href' );

		$gallery_nav_img_wrap.wc_set_variation_attr( 'data-image_id', $gallery_nav_img_wrap.data('o_image_id') );
		$product_gallery.trigger( 'cs_woocommerce_gallery_reset_slide_position' );

	};

	});

})( jQuery, window, document );
