<?php
class ControllerCommonHeader extends Controller {
    public function index() {
        // Заголовок страницы
        $data['title'] = 'Orcart Store';

        $data['cart_total'] = isset($this->session->data['cart_count']) ? $this->session->data['cart_count'] : 0;

        // Массив стилей (потом сможешь добавлять сюда другие файлы)
        $data['styles'] = [
            'catalog/view/stylesheet/stylesheet.css'
        ];

        // Загружаем вьюху хедера и возвращаем её HTML
        return $this->load->view('common/header', $data);
    }
}
