<?php
class SeoUrl {
    private $db;

    public function __construct($registry) {
        $this->db = $registry->get('db');
    }

    public function rewrite() {
        if (!isset($_GET['_route_'])) {
            return;
        }

        $parts = explode('/', $_GET['_route_']);
        foreach ($parts as $part) {
            if (empty($part)) continue;

            // Ищем в БД соответствие ключевого слова
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE keyword = '" . $this->db->escape($part) . "'");

            if ($query->num_rows) {
                $url = explode('=', $query->row['query']);

                if ($url[0] == 'product_id')     $_GET['product_id'] = $url[1];
                if ($url[0] == 'category_id')    $_GET['category_id'] = $url[1];
                if ($url[0] == 'information_id') $_GET['information_id'] = $url[1];

                // Если в query прямо прописан route (например, 'route=common/home')
                if ($url[0] == 'route') $_GET['route'] = $url[1];
            } else {
                $_GET['route'] = 'error/not_found';
            }
        }

        // Определяем контроллер по приоритету
        if (isset($_GET['product_id'])) {
            $_GET['route'] = 'product/product';
        } elseif (isset($_GET['category_id'])) {
            $_GET['route'] = 'product/category';
        }
    }


    public function link($route, $args = '') {
        $url = 'index.php?route=' . $route;
        if ($args) {
            // Убираем лишние амперсанды и добавляем аргументы (например, &path=1_2)
            $url .= '&' . ltrim($args, '&');
        }
        return $url;
    }

}
