<?php
class ControllerProductCategory extends Controller {
    public function index() {
        $this->load->model('catalog/category');

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => 'Главная',
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['path'])) {
            $path = '';
            $parts = explode('_', (string)$this->request->get['path']);

            // ID текущей категории — это последний элемент в пути
            $category_id = (int)end($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path .= '_' . (int)$path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path)
                    );
                }
            }
        } else {
            $category_id = 0;
        }

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $data['heading_title'] = $category_info['name'];

            // Получаем вложенные категории для отображения в контенте
            $data['categories'] = array();
            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {
                $data['categories'][] = array(
                    'name' => $result['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'])
                );
            }

            $this->load->model('catalog/product');
            $data['products'] = array();
            $results = $this->model_catalog_product->getProducts(array('filter_category_id' => $category_id));

            foreach ($results as $result) {
                $data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'name'       => $result['name'],
                    'price'      => $result['price'],
                    'image'      => $result['image'],
                    'href'       => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'])
                );
            }


            // Магия: вызываем контроллер хедера и записываем его результат в переменную
            $data['header'] = $this->load->controller('common/header');
            $data['menu'] = $this->load->controller('common/menu');
            $data['footer'] = $this->load->controller('common/footer'); // Если создашь его


            // Рендер шаблона (например, category.twig или .tpl)
            $this->response->setOutput($this->load->view('product/category', $data));
        } else {
            // Тут логика 404, если категория не найдена
            $data['heading_title'] = 'Категория не найдена';
            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }
}
