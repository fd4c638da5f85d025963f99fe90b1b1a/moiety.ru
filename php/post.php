   <?
   if (is_numeric($_GET['id'])) {
    $post = sendQuery('SELECT title, `desc-full` FROM posts WHERE id = ? LIMIT 1', array($_GET['id']))->fetch(PDO::FETCH_BOTH);
    if ($post) {
     $checkView = sendQuery('SELECT count(*) FROM views WHERE post_id = ? AND ipv4 = ?', array($_GET['id'], $_SERVER['REMOTE_ADDR']))->fetchColumn();
     if ($checkView == 0) {
      sendQuery('INSERT INTO `views`(`post_id`, `ipv4`, `date`) VALUES (?, ?, ?)', array($_GET['id'], $_SERVER['REMOTE_ADDR'], time()));
     }

     if (strlen($_POST['name']) > 1 AND strlen($_POST['comment']) > 1) {
        if (sendQuery('SELECT count(*) FROM comments WHERE post_id = ? AND ipv4 = ?', array($_GET['id'], $_SERVER['REMOTE_ADDR']))->fetchColumn() != 1) {
            sendQuery('INSERT INTO `comments` (`post_id`, `name`, `comment`, `date`, `ipv4`) VALUES (?, ?, ?, ?, ?)', array($_GET['id'], htmlspecialchars($_POST['name']), htmlspecialchars($_POST['comment']), time(), $_SERVER['REMOTE_ADDR']));
            $alert = str_replace('{TEXT}', $local->add_comment->success, getTpl('alert_success'));
        } else {
            $alert = str_replace('{TEXT}', $local->add_comment->error, getTpl('alert_error'));
        }
    }

    $commentForm = getTpl('add_comment');

     $getComments = sendQuery('SELECT name, comment, ipv4 FROM `comments` WHERE post_id = ? ORDER BY id DESC', array($_GET['id']))->fetchAll();
     if ($getComments) {
      foreach ($getComments as $comment) {
       $comments .= str_replace(array('{NAME}', '{COMMENT}'), array($comment['name'], $comment['comment']), getTpl('comment'));
       if ($comment['ipv4'] == $_SERVER['REMOTE_ADDR']) $commentForm = null;
      }
     }
     else {
      $comments = getTpl('comments_empty');
     }

     $title = $post['title'];
     $content = str_replace(array('{TITLE}', '{DESC-FULL}', '{COMMENTS}', '{ALERT}', '{ADD_COMMENT}'), array($post['title'], htmlspecialchars_decode($post['desc-full']), $comments, $alert, $commentForm), getTpl('post'));
    }
    else {
     showException('post_not_found');
    }
   }
   else {
    showException('post_wrong_id');
   }
   ?>