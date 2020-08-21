$(function () {

  var speed = 0;
  var scroll = 0;
  var container = $('.container');
  var container_w = container.width();
  var max_scroll = container.scrollWidth - container.outerWidth();

  $('.nav-scroller').on('mousemove', function(e){
      var mouse_x = e.pageX - container.offset().left;
      var mouseperc = 100 * mouse_x / container_w;
      speed = mouseperc - 50;
  }).on ( 'mouseleave', function() {
      speed = 0;
  });

  function updatescroll() {

      if (speed !== 0) {
          scroll += speed / 5;
          if (scroll < 0) scroll = 0;
          if (scroll > max_scroll) scroll = max_scroll;

          $('.nav-scroller .nav').scrollLeft(scroll);
      }
      //$("#speed").html('Speed: ' + speed);
      //$("#scroll").html('Scroll: ' + scroll);
      window.requestAnimationFrame(updatescroll);
  }
  window.requestAnimationFrame(updatescroll);




  scrollToBottom();

  $('[data-toggle="tooltip"]').tooltip();

  if($( document ).width() <= 992)
  {
    $('.message-area').css('min-height', $( document ).height() - 325 );
  }

});

function scrollToBottom()
{
  $('.message-area').animate({ scrollTop: 2000 }, 'slow');
}

$( window ).resize(function() {
  scrollToBottom();
});

$('.navigation-right').on('click', function(){
  $('.nav-scroller .nav').scrollRight(40);
});

$('.navigation-left').on('click', function(){
  $('.nav-scroller .nav').scrollLeft(40);
});
