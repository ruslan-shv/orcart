<?php
class ControllerCommonHeader extends Controller {
    public function index() {
        // Заголовок страницы
        $data['title'] = 'Orcart Store';

        // Массив стилей (потом сможешь добавлять сюда другие файлы)
        $data['styles'] = [
            'catalog/view/stylesheet/stylesheet.css'
        ];

        // Загружаем вьюху хедера и возвращаем её HTML
        return $this->load->view('common/header', $data);
    }
}
