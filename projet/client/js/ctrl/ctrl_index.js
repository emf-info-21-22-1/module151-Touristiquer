
$(document).ready(function () {
  var scrollStep = $('.scroll-content').outerWidth(true);
  var containerWidth = $('.scroll-container').width();
  var scrollContentWidth = $('.scroll-content').width();
  var maxScroll = scrollContentWidth - containerWidth;

  $('.next').click(function () {
    var currentScroll = $('.scroll-content').css('transform').match(/(\d+)/)[0];
    var newScroll = parseInt(currentScroll) - scrollStep;
    if (newScroll < -maxScroll) {
      newScroll = -maxScroll;
    }
    $('.scroll-content').css('transform', 'translateX(' + newScroll + 'px)');
  });

  $('.prev').click(function () {
    var currentScroll = $('.scroll-content').css('transform').match(/(\d+)/)[0];
    var newScroll = parseInt(currentScroll) + scrollStep;
    if (newScroll > 0) {
      newScroll = 0;
    }
    $('.scroll-content').css('transform', 'translateX(' + newScroll + 'px)');
  });
});



