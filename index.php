<?php
require_once 'php/api.php';
$title = $local->title;
if (!empty($page)) {
switch ($page) {
   case 'portfolio':
      $title = $title->portfolio;
      $content = getTpl('portfolio');
   break;
   case 'about':
      $title = $title->about;
      $content = getTpl('about');
   break;
   case 'blog':
      require_once 'php/blog.php';
   break;
   case 'contacts':
      $title = $title->contacts;
      $content = getTpl('contacts');
   break;
   default:
   showException('not_found');
   break;
}
} else {
   $title = $title->label;
   $content = getTpl('landing');
}
if (isset($_POST['ajax'])) {
exit(serialize(array($title, $content)));
} else {
if (!$description) $description = $local->description;
exit(str_replace(
   array('{TITLE}', '{CONTENT}', '"/'.$page.'"'),
    array($title, $content,'"/'.$page.'" class="selected"'),
     getTpl('main')));
}
?>