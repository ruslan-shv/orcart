<?php
class ControllerCommonHome extends Controller {
    public function index() {
        $this->load->model('catalog/product');


        // Магия: вызываем контроллер хедера и записываем его результат в переменную
        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer'); // Если создашь его
        $data['menu'] = $this->load->controller('common/menu');

        // 2. Теперь модель доступна как свойство контроллера через магию Registry
        $results =  $this->model_catalog_product->getLatest(8);

        foreach ($results as $result) {
            $data['latest'][] = array(
                'product_id' => $result['product_id'],
                'name'       => $result['name'],
                'thumb'      => $this->image->getResize($result['image'], 250, 250),
                'price'      => $result['price'],
                // Генерируем ссылку в контроллере!
                'href'       => $this->url->link('product/product', 'product_id=' . $result['product_id'])
            );
        }

        $this->response->setOutput($this->load->view('common/home', $data));
    }

}