<?php
class ControllerCheckoutCart extends Controller {
    // Метод для добавления товара (вызывается через AJAX)
    public function add() {
        $json = [];

        // Проверяем, существует ли объект сессии в реестре
        if (!$this->session) {
            $json['error'] = 'Ошибка системы: Сессия не найдена';
        } else {
            $product_id = (int)$this->request->post['product_id'];
            $quantity = (int)$this->request->post['quantity'];

            // 1. Копируем массив данных сессии во временную переменную
            $session_data = $this->session->data;

            // 2. Инициализируем корзину, если её нет
            if (!isset($session_data['cart'])) {
                $session_data['cart'] = [];
            }

            // 3. Добавляем товар
            if (isset($session_data['cart'][$product_id])) {
                $session_data['cart'][$product_id] += $quantity;
            } else {
                $session_data['cart'][$product_id] = $quantity;
            }

            // 4. Записываем измененный массив обратно в объект сессии
            $this->session->data = $session_data;

            $json['success'] = 'Товар добавлен!';
            $json['total'] = count($this->session->data['cart']);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
