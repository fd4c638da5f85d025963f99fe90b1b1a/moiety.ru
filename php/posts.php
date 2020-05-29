   <?
   $title = $title->posts;
   $count = sendQuery('SELECT count(*) FROM `posts`', null)->fetchColumn();
   if ($_GET['page'] > 1) {
    $page = $_GET['page'];
    $title .= ' / ' . $local->page . ' ' . $page;
    $offset = ($page - 1) * 10;
    $limit = 10;
    $response = sendQuery('SELECT * FROM `posts` ORDER BY `id` DESC LIMIT ' . $offset . ', ' . $limit, null)->fetchAll();
   }
   else {
    $page = 1;
    $response = sendQuery('SELECT * FROM `posts` ORDER BY `id` DESC LIMIT 10', null)->fetchAll();
   }
   if (!empty($response)) {
    foreach ($response as $post) {
     $posts .= str_replace(array('{ID}', '{TITLE}', '{DESC}', '{VIEWS}', '{COMMENTS}', '{DATE}'), array($post['id'], $post['title'], htmlspecialchars_decode($post['desc']), getViewsCount($post['id']) . ' ' . trueWord(getViewsCount($post['id']), 'просмотр', 'просмотра', 'просмотров'), getCommentsCount($post['id']) . ' ' . trueWord(getCommentsCount($post['id']), 'комментарий', 'комментария', 'комментариев'), timeTransform($post['date'])), getTpl('posts_row'));
    }
    $content = str_replace(array('{POSTS}', '{COUNT}', '{PAGES}'), array($posts, $count, showPages($count)), getTpl('posts'));
   }
   else {
    showException('posts_not_found');
   }
   ?>