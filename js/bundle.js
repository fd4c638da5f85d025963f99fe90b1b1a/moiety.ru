var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
    var t;
    function up() {
      var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
      if(top > 0) {
        window.scrollBy(0,-100);
        t = setTimeout('up()',20);
      } else clearTimeout(t);
      return false;
    }
    function hrAjax(vUrl) {
      $('[content], a').attr('loading',true);
      up();
      var request = $.ajax({
        url: vUrl,
        type: "POST",
        data: {ajax : true},
        cache: true
      });
      request.done(function(msg) {
        result = PHPUnserialize.unserialize(msg);
        document.title = result[0];
        $("[content]").html(result[1]);
        $('[content], [loading]').removeAttr('loading');
      });
    }
    window.onload = function() {
    $("body").on('click', 'menu a, #ajax', function() {
      hrAjax(this.href);
      history.pushState(null, null, this.href);
      selectedLink = $("menu").find('a[href="'+location.pathname+'"]')[0];
        $('a.selected').removeAttr('class');
        $(selectedLink).addClass("selected");
      return false;
    });
    window.addEventListener("popstate", function(e) {
      hrAjax(location.pathname);
    });
  }