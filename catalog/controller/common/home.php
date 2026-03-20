<?php
class ControllerCommonHome extends Controller {
    public function index() {
        $data['message'] = "Привет! Это мой движок, совместимый с orcart!";
        
        // Выводим результат в браузер через Loader
        echo $this->load->view('common/home', $data);
    }
}