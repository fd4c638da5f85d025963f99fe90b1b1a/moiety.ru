<?
$page = $_GET['p'];
$config = json_decode(file_get_contents('config.json'));
$local = json_decode(file_get_contents('language.json'));
$db = new PDO('mysql:host=' . $config->db->host . ';dbname=' . $config->db->name, $config->db->user, $config->db->pass);
$encode = $db->prepare("SET NAMES 'utf8';");
$execute = $encode->execute();

function trueWord($num, $form_for_1, $form_for_2, $form_for_5) {
 $num = abs($num) % 100;
 $num_x = $num % 10;
 if ($num > 10 and $num < 20) return $form_for_5;
 if ($num_x > 1 and $num_x < 5) return $form_for_2;
 if ($num_x == 1) return $form_for_1;
 return $form_for_5;
}
function timeTransform($unix) {
    global $local;
 $time = time();
 $tm = date('H:i', $unix);
 $d = date('d', $unix);
 $m = date('m', $unix);
 $y = date('Y', $unix);
 $last = round(($time - $unix) / 60);
 if ($last < 1) return $local->time->varNow;
 elseif ($last < 55) return $last  .' '. trueWord($last, $local->time->varType1, $local->time->varType2, $local->time->varType3) .' '. $local->time->varAgo;
 elseif ($d . $m . $y == date('dmY', $time)) return $local->time->varToday .' '. $tm;
 elseif ($d . $m . $y == date('dmY', strtotime('-1 day'))) return $local->time->varYesterday .' '. $tm;
 elseif ($y == date('Y', $time)) return "$tm $d/$m";
 else return "$tm $d/$m/$y";
}
function showException($module) {
 global $local;
 exit(str_replace(array('{HEADER}', '{DESCRIPTION}'), array($local->error->$module->header, $local->error->$module->text), getTpl('error')));
}
function sendQuery($query, $vars) {
 global $db;
 if (!$db) {
  showException('db_connect');
 }
 $prepare = $db->prepare($query);
 $execute = $prepare->execute($vars);
 if ($execute) {
  return $prepare;
 }
 else {
  showException('db_query');
 }
}
function getTpl($filename) {
 global $config;
 return file_get_contents($config->tpl . '/' . $filename . '.html');
}
function getViewsCount($id) {
 if (!empty($id)) {
  return sendQuery('SELECT count(*) FROM views WHERE post_id = ?', array($id))->fetchColumn();
 }
 else return false;
}
function getCommentsCount($post_id) {
 if (!empty($post_id)) {
  return sendQuery('SELECT count(*) FROM comments WHERE post_id = ?', array($post_id))->fetchColumn();
 }
 else {
  return false;
 }
}
function showPages($count) {
    for ($i = 1;$i <= $count / 10;$i++) {
        if ($i == $page) {
         $pages .= str_replace(array('{LINK}','{NUMBER}'), array($_GET['module'].'-'.$i, $i), getTpl('page_current'));
        }
        else {
         $pages .= str_replace(array('{LINK}','{NUMBER}'), array($_GET['module'].'-'.$i, $i), getTpl('page'));
        }
       }
       if ($pages) return str_replace('{PAGES}', $pages, getTpl('pages'));
       else return false;
}
?>