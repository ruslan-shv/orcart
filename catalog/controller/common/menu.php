<?php
class ControllerCommonMenu extends Controller {
    public function index() {
        $this->load->model('catalog/category');

        $data['categories'] = array();

        // Получаем главные категории
        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            // Получаем подкатегории для каждой главной
            $children_data = array();
            $children = $this->model_catalog_category->getCategories($category['category_id']);

            foreach ($children as $child) {
                $children_data[] = array(
                    'name' => $child['name'],
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                );
            }

            $data['categories'][] = array(
                'name'     => $category['name'],
                'children' => $children_data,
                'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }

        return $this->load->view('common/menu', $data);
    }
}
