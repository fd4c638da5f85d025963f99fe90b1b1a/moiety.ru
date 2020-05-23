<?
$page = $_GET['p'];
function get($name) {
   return file_get_contents('index/'.$name.'.html');
}
if (!empty($page)) {
switch ($page) {
   case 'portfolio':
      $title = 'Портфолио';
       $content = get('portfolio');
   break;
   case 'about':
      $title = 'Обо мне';
      $content = get('about');
   break;
   case 'blog':
      $title = 'Блог';
      $content = null;
   break;
   case 'contacts':
      $title = 'Контакты';
      $content = get('contacts');
   break;
   default:
       $title = 'Эта страница не найдена';
       $content = get('errors/404');
   break;
}
} else {
   $title = 'Moiety - верстка сайтов';
   $content = get('home');
}
?>
<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title><? echo $title; ?></title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://kit.fontawesome.com/cecc7403a6.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" media="all" href="../css/swiper.min.css" />
      <link rel="stylesheet" media="all" href="../css/style.css" />
   </head>
   <body>
      <header>
         <div class="container text-sm-center pt-3">
            <div class="row">
               <div class="col-12 col-md-3">
                  <span class="logo text-center">Moiety</span>
               </div>
               <div class="col-12 col-md-6">
                  <menu>
                     <a href="/" class="selected">Главная</a>
                     <a href="/portfolio">Портфолио</a>
                     <a href="/about">Обо мне</a>
                     <a href="/blog">Блог</a>
                     <a href="/contacts">Контакты</a>
                  </menu>
               </div>
               <div class="col-12 col-md-3">
                  <a href="#" class="purchase mb-3 d-none d-md-inline-block">
                  <i class="fas fa-laptop-house"></i>
                  Отправить задание
                  </a>
               </div>
            </div>
         </div>
      </header>
      <div class="container">
         <? echo $content; ?>
      </div>
      <script src="../js/swiper.min.js"></script>
      <script src="../js/bundle.js"></script>
   </body>
</html>