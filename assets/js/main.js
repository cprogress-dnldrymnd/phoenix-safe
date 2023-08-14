
jQuery(document).ready(function ($) {

  elementor_slider();
  latest_post();
  footer_accordion();
  anchor_section();
});

function anchor_section() {
  jQuery('.anchor-section').click(function (e) {
    $target = jQuery(this).find('.elementor-button-link').attr('href');
    console.log($target);
    window.location.href = $target;

  });
}
function footer_accordion() {

  if (window.innerWidth < 768) {
    jQuery('.widget_nav_menu .widget-title').click(function (e) {
      jQuery('.widget_nav_menu').removeClass('open-menu');
      jQuery(this).parent().toggleClass('open-menu');
      e.preventDefault();
    });
  }
}

function latest_post() {
  if (window.innerWidth > 991) {
    jQuery('.latest-post-item').each(function (index, element) {
      jQuery(this).find('.blog-title').appendTo(jQuery(this).find('.latest-post-image'));
    });
  }
}

function elementor_slider() {
  $pagination = jQuery('<div class="e-con swiper-pagination-holder"><div class="e-con-inner"><div class="swiper-pagination swiper-pagination-elementor"></div></div></div>');
  $pagination.insertAfter('.elementor-swiper-slider-js .swiper-wrapper');
  setTimeout(function () {
    var elementorSlider = new Swiper(".elementor-swiper-slider-js", {
      loop: false,
      spaceBetween: 0,
      slidesPerView: 1,
      autoplay: false,
      pagination: {
        el: ".swiper-pagination",
        clickable: true
      },

    });

  }, 1000);
  jQuery('body:not(.elementor-editor-active) .elementor-swiper-slider-js-vertical > div').addClass('swiper-wrapper');
  $pagination = jQuery('<div class="swiper-pagination swiper-pagination--vertical swiper-pagination-elementor"></div>');
  $pagination.insertAfter('.elementor-swiper-slider-js-vertical .swiper-wrapper');
  setTimeout(function () {
    if (window.innerWidth > 991) {
      var $direction = 'vertical';
    } else {
      var $direction = 'horizontal';
    }

    var elementorSliderVertical = new Swiper(".elementor-swiper-slider-js-vertical", {
      loop: false,
      slidesPerView: 1,
      direction: $direction,
      autoHeight: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: true,
      },
      pagination: {
        el: ".swiper-pagination--vertical",
        clickable: true
      },
    });

  }, 1000);




}