$(function(){
  // form
  var ind=0;
  var fs=0;
  $(function(){
    $(document).on('mousedown','input, select, textarea',function(){
      fs=$(this).css("font-size");
      $(this).css("font-size","16px");
      ind=$('input, select, textarea').index(this);
      setTimeout(function(){
        $('input, select, textarea').eq(ind).css("font-size",fs);
      },1);
    });
  });



  // lazyload
  $("img.lazyload").lazyload();



  // slick
  $('.slider').slick({
    lazyLoad: 'progressive',
    mobileFirst: true,
    appendArrows: '.slider-nav',
    appendDots: '.slider-nav',
    prevArrow: '<div class="slick-arrow slick-prev" ontouchstart="">PREV</div>',
    nextArrow: '<div class="slick-arrow slick-next" ontouchstart="">NEXT</div>',
    infinite: false,
    slidesToShow: 2,
    slidesToScroll: 2,
    rows: 3,
    responsive: [
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4,
          rows: 2,
        }
      },
      {
        breakpoint: 768,
        settings: {
          appendArrows: '.slider-nav__inner',
          appendDots: '.slider-nav__inner',
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 3,
          rows: 3,
          dots: true,
          infinite: true,
        }
      },
      {
        breakpoint: 992,
        settings: {
          appendArrows: '.slider-nav__inner',
          appendDots: '.slider-nav__inner',
          slidesToShow: 4,
          slidesToScroll: 4,
          rows: 3,
          dots: true,
          infinite: true,
        }
      },
      {
        breakpoint: 1200,
        settings: {
          appendArrows: '.slider-nav__inner',
          appendDots: '.slider-nav__inner',
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 5,
          rows: 3,
          dots: true,
          infinite: true,
        }
      },
      {
        breakpoint: 1456,
        settings: {
          appendArrows: '.slider-nav__inner',
          appendDots: '.slider-nav__inner',
          infinite: true,
          slidesToShow: 6,
          slidesToScroll: 6,
          rows: 3,
          dots: true,
          infinite: true,
        }
      },
    ],
  });



  //lightbox
  lightbox.option({
    'wrapAround': true,
    'alwaysShowNavOnTouchDevices': true
  });



  // banner
  $('#banner__input')
    .focus(function(){
      $(this).select();
      $('.banner__body').addClass('active');
    })
    .blur(function(){
      $('.banner__body').removeClass('active');
    })
    .click(function(){
      $(this).select();
      $('.banner__body').addClass('active');
      return false;
  });
});
