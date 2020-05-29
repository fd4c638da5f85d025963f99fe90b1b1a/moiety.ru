   <?
   $title = $title->callbacks;
   $content = str_replace('{CALLBACKS}',$callbacks,getTpl('callbacks'));
   if (true) {
    $callbacks .= str_replace('{CALLBACK}','Был приятный и полезный процесс общения. Спасибо за работу.', getTpl('callback'));
    $callbacks .= str_replace('{CALLBACK}','Ребята вы супер. Так держать.', getTpl('callback'));
    $callbacks .= str_replace('{CALLBACK}','Пользуюсь Ваши услугами не первый раз, вероятность рекомендации высокая.', getTpl('callback'));
    $content = str_replace('{CALLBACKS}',$callbacks,getTpl('callbacks'));

    $head   .= '<link type="text/css" rel="stylesheet" href="{CDN}/css/swiper.css">';
    $onload .= '<script src="{CDN}/js/swiper.js"></script>';
    $onload .= '<script>
    $(function() {
        var swiper = new Swiper(\'.swiper-container\', {
            simulateTouch: false,
            navigation: {
                nextEl: \'.swiper-button-next\',
                prevEl: \'.swiper-button-prev\',
            },
        });
    });
    </script>';
   }
   else {
    showException('callbacks_not_found');
   }
   ?>