jQuery(document).ready(function(){

  jQuery('.multiple-items-js').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay:true,
    speed: 1400,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      ]

  });
  
});
jQuery(document).ready(function(){
    jQuery('.related-posts-front .row').slick({
      dots: false,
      infinite: true,
      arrows:false,
      speed: 500,
      slidesToShow: 4,
      autoplay:true,
      slidesToScroll: 1,
      fade: false,
      swipeToSlide: true,
      responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1
        },
        breakpoint: 480,
        settings: {
          slidesToShow: 2
        }
      }
      ]
    });
  });
  
  jQuery(document).ready(function(){
    jQuery('.post-slider').slick({
      dots: true,
      infinite: true,
      arrows: false,
      speed: 1000,
      slidesToShow: 1,
      autoplay:true,
      slidesToScroll: 1
    });
  });
  
  
  jQuery(document).ready(function(){
    jQuery('.instagram .row').slick({
      dots: false,
      infinite: true,
      arrows:false,
      speed: 500,
      slidesToShow: 6,
      autoplay:true,
      slidesToScroll: 1,
      fade: false,
      swipeToSlide: true,
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
      ]
    });
  });
  
  jQuery(document).ready(function(){
    jQuery('.related-posts .row').slick({
      dots: true,
      infinite: true,
      arrows:false,
      speed: 500,
      slidesToShow: 2,
      autoplay:true,
      slidesToScroll: 1,
      fade: false,
      swipeToSlide: true,
      responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1
        }
      }
      ]
    });
  });
  
  
  jQuery(function () {
    jQuery('a[href="#search"]').on('click', function(event) {
      event.preventDefault();
      jQuery('#search').addClass('open');
      jQuery('#search > form > input[type="search"]').focus();
    });
  
    jQuery('#search, #search button.close').on('click keyup', function(event) {
      if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
        jQuery(this).removeClass('open');
      }
    });
  });
  
  // jQuery('[data-sidenav]').sidenav();
  
  (function($) {
    "use strict";
     $(document).on('ready', function() {	
  
    /*====================================
          Scrool Up
        ======================================*/ 	
        $.scrollUp({
          scrollName: 'scrollUp',      // Element ID
          scrollDistance: 800,         // Distance from top/bottom before showing element (px)
          scrollFrom: 'top',           // 'top' or 'bottom'
          scrollSpeed: 1000,            // Speed back to top (ms)
          animationSpeed: 200,         // Animation speed (ms)
          scrollTrigger: false,        // Set a custom triggering element. Can be an HTML string or jQuery object
          scrollTarget: false,         // Set a custom target element for scrolling to. Can be element or number
          scrollText: ["<i class='fa fa-arrow-circle-up'></i>"], // Text for element, can contain HTML
          scrollTitle: false,          // Set a custom <a> title if required.
          scrollImg: false,            // Set true to use image
          activeOverlay: false,        // Set CSS color to display scrollUp active point, e.g '#00FFFF'
          zIndex: 2147483647           // Z-Index for the overlay
        });   
  
    });	
  
    if(jQuery('#scroll-top div').hasClass('col-lg-12'))   {
      jQuery('.wp-block-image.alignfull img').css('max-width','125%' ) ;
      jQuery('.wp-block-image.alignfull img').css('width','125%');
      jQuery('.wp-block-image.alignfull img').css('margin-left','-12.5%');
      jQuery('.wp-block-image.alignwide').css('max-width','108%');
      jQuery('.wp-block-image.alignwide').css('width','108%');
      jQuery('.wp-block-image.alignwide').css('margin-left','-4%');
  
      jQuery('.wp-block-media-text.alignwide').css('margin-left','-6%' ) ;
      jQuery('.wp-block-media-text.alignwide').css('width','115%');
  
      jQuery('.wp-block-media-text.alignfull').css('margin-left','-12.5%' ) ;
      jQuery('.wp-block-media-text.alignfull').css('width','125%');
  
  
      /** for post gallery */
  
      jQuery('.detail-block .thumb-body ul.wp-block-gallery.alignwide').css('max-width','112%');
      jQuery('.detail-block .thumb-body ul.wp-block-gallery.alignwide').css('width','112%');
      jQuery('.detail-block .thumb-body ul.wp-block-gallery.alignwide').css('margin-left','-6%');
  
      jQuery('.detail-block .thumb-body ul.wp-block-gallery.alignfull').css('max-width','125%');
      jQuery('.detail-block .thumb-body ul.wp-block-gallery.alignfull').css('width','125%');
      jQuery('.detail-block .thumb-body ul.wp-block-gallery.alignfull').css('margin-left','-12.5%');
  
      /** for page gallery */
      jQuery('#scroll-top .entry-content ul.wp-block-gallery.alignwide').css('max-width','112%');
      jQuery('#scroll-top .entry-content ul.wp-block-gallery.alignwide').css('width','112%');
      jQuery('#scroll-top .entry-content ul.wp-block-gallery.alignwide').css('margin-left','-6%');
  
      jQuery('#scroll-top .entry-content ul.wp-block-gallery.alignfull').css('max-width','125%');
      jQuery('#scroll-top .entry-content ul.wp-block-gallery.alignfull').css('width','125%');
      jQuery('#scroll-top .entry-content ul.wp-block-gallery.alignfull').css('margin-left','-12.5%');
  
    }

    /** below for close menu after press tab at the end of last element of menu but do nothing if press shift tab */

    $('#site-navigation ul a:last').focusout(function(){
      var new_blog_jr_keypress;
      new_blog_jr_keypress = "nowfocusout";
      
      if(screen.width < 992 || $( window ).width() < 992 ){
              $(document).keyup(function (e) {
                if (e.which === 9 && e.shiftKey) {
                } else if (e.which === 9 && new_blog_jr_keypress =='nowfocusout'){
                  $('#site-navigation ul:first').addClass('unique-main-menu');
                  $('.unique-main-menu').hide();
                  $('#collapse-1').removeClass('show');
                  $(".menu-toggle").focus();
                  new_blog_jr_keypress = "stillfocus";
                }
            });
      }
    });
    
    var width = $(window).width();
    $(window).on('resize', function() {
      if ($(this).width() !== width) {
        width = $(this).width();
         if( width < 992 ){
            $('.unique-main-menu').hide();
          }
          if( width > 991 ){
            $('.unique-main-menu').show(); 
          }
      }
    });
   
    $(".menu-toggle").on('click',function(){
      $('#site-navigation ul.navbar-nav').show();
    });
    /** below for close menu after press shift tab from first element of menu */
      $('.menu-toggle').focusin(function()   {
        if ($('#collapse-1').hasClass('show') ){
          $('#site-navigation ul:first').addClass('unique-main-menu');
          $('.unique-main-menu').hide();
          $('#collapse-1').removeClass('show');
          $(".menu-toggle").focus();
        }
    });
      // Handler for .ready() called.
    jQuery('html, body').animate({
        scrollTop: jQuery('#scroll-top').offset().top
    }, 'slow');
  })(jQuery);
  
  /** prevent scroll to top if there is hash on menu*/
  ( function( $ ) {
    $( 'a[href="#"]' ).click( function(e) {
       e.preventDefault();
    } );
  } )( jQuery );