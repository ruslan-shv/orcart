<?php
class ControllerProductProduct extends Controller {
    public function index() {
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');

        $product_id = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            $data['product_id'] = $product_id;
            $data['heading_title'] = $product_info['name'];
            $data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
            $data['price'] = number_format($product_info['price'], 0, '.', ' ');
            $data['image'] = 'image/' . ($product_info['image'] ?: 'no-image.png');

            // Хлебные крошки
            $data['breadcrumbs'] = [];
            $data['breadcrumbs'][] = ['text' => 'Главная', 'href' => $this->url->link('common/home')];

            if (isset($this->request->get['path'])) {
                $path = '';
                $parts = explode('_', (string)$this->request->get['path']);
                foreach ($parts as $path_id) {
                    $path .= (!$path ? (int)$path_id : '_' . (int)$path_id);
                    $category_info = $this->model_catalog_category->getCategory($path_id);
                    if ($category_info) {
                        $data['breadcrumbs'][] = ['text' => $category_info['name'], 'href' => $this->url->link('product/category', 'path=' . $path)];
                    }
                }
            }

            $data['header'] = $this->load->controller('common/header');
            $data['footer'] = $this->load->controller('common/footer');
            $data['menu'] = $this->load->controller('common/menu');

            $this->response->setOutput($this->load->view('product/product', $data));
        } else {
            // 404 если товар не найден
            $this->response->setOutput('Товар не найден');
        }
    }
}
