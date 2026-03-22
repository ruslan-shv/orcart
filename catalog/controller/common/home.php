<?php
class ControllerCommonHome extends Controller {
    public function index() {
        $this->load->model('catalog/product');


        // Магия: вызываем контроллер хедера и записываем его результат в переменную
        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer'); // Если создашь его

        // 2. Теперь модель доступна как свойство контроллера через магию Registry
        $data['latest'] = $this->model_catalog_product->getLatest(8);


        $this->response->setOutput($this->load->view('common/home', $data));
    }

}