   <?
   $title = $title->products;
   $count = sendQuery('SELECT count(*) FROM `products`', null)->fetchColumn();
   if ($_GET['page'] > 1) {
    $page = $_GET['page'];
    $title .= ' / ' . $local->page . ' ' . $page;
    $offset = ($page - 1) * 10;
    $limit = 10;
    $response = sendQuery('SELECT * FROM `products` ORDER BY `id` DESC LIMIT ' . $offset . ', ' . $limit, null)->fetchAll();
   }
   else {
    $page = 1;
    $response = sendQuery('SELECT * FROM `products` ORDER BY `id` DESC LIMIT 10', null)->fetchAll();
   }
   if ($response) {
    foreach ($response as $post) {
     $products .= str_replace(array('{ID}', '{TITLE}', '{DESC}', '{VIEWS}', '{COMMENTS}', '{DATE}'), array($post['id'], $post['title'], htmlspecialchars_decode($post['desc']), getViewsCount($post['id']) . ' ' . trueWord(getViewsCount($post['id']), 'просмотр', 'просмотра', 'просмотров'), getCommentsCount($post['id']) . ' ' . trueWord(getCommentsCount($post['id']), 'комментарий', 'комментария', 'комментариев'), timeTransform($post['date'])), getTpl('product'));
    }
    $content = str_replace(array('{PRODUCTS}', '{COUNT}', '{PAGES}'), array($products, $count, showPages($count)), getTpl('products'));
   }
   else {
    showException('products_not_found');
   }
   ?>