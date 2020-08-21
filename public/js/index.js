$(function () {

  //Detail page
  $('[data-toggle="tooltip"]').tooltip();

  //List page
  $('#dismiss, .overlay').on('click', function () {
      $('#sidebar').removeClass('active');
      $('.overlay').removeClass('active');
  });
  $('#sidebarCollapse').on('click', function () {
      $('#sidebar').addClass('active');
      $('.overlay').addClass('active');
      $('.collapse.in').toggleClass('in');
      $('a[aria-expanded=true]').attr('aria-expanded', 'false');
  });

  //Index
  var owl = $('.owl-6');
  owl.owlCarousel({
      items:6,
      lazyLoad:true,
      loop:true,
      autoplay:true,
      autoplayTimeout:4000,
      autoplayHoverPause:true,
      responsive:{
          0:{
              items:1,
              nav:false
          },
          600:{
              items:3,
              nav:false
          },
          1000:{
              items:6,
              nav:false
          }
      }
  });

  var owl2 = $('.owl-4');
  owl2.owlCarousel({
      items:4,
      lazyLoad:true,
      loop:true,
      autoplay:true,
      autoplayTimeout:3000,
      autoplayHoverPause:true,
      responsive:{
          0:{
              items:1,
              nav:false
          },
          600:{
              items:2,
              nav:false
          },
          1000:{
              items:4,
              nav:false
          }
      }
  });

});
