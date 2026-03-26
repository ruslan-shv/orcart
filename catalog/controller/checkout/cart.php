<?php
class ControllerCheckoutCart extends Controller {

    public function index() {
        $this->load->model('catalog/product');

        $data['products'] = [];
        $data['total_price_raw'] = 0;

        if (!empty($this->session->data['cart'])) {
            foreach ($this->session->data['cart'] as $product_id => $quantity) {
                $product_info = $this->model_catalog_product->getProduct($product_id);

                if ($product_info) {
                    $price = (float)$product_info['price'];
                    $subtotal = $price * $quantity;
                    $data['total_price_raw'] += $subtotal;

                    $data['products'][] = [
                        'product_id' => $product_id,
                        'name'       => $product_info['name'],
                        'quantity'   => $quantity,
                        'price'      => number_format($price, 0, '.', ' ') . ' ₽',
                        'total'      => number_format($subtotal, 0, '.', ' ') . ' ₽',
                        // Используем твой стандартный метод вывода картинок
                        'thumb'      => $this->image->getResize($product_info['image'], 100, 100)
                    ];
                }
            }
        }

        $data['total_price'] = number_format($data['total_price_raw'], 0, '.', ' ') . ' ₽';

        $data['header'] = $this->load->controller('common/header');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('checkout/cart', $data));
    }


    public function add() {

        $json = [];
        $product_id = (int)$this->request->post['product_id'];
        $quantity = (int)$this->request->post['quantity'];

        // Работаем с сессией через временную переменную (из-за перегрузки)
        $session_data = $this->session->data;

        if (!isset($session_data['cart'])) {
            $session_data['cart'] = [];
        }

        // Добавляем/обновляем товар
        if (isset($session_data['cart'][$product_id])) {
            $session_data['cart'][$product_id] += $quantity;
        } else {
            $session_data['cart'][$product_id] = $quantity;
        }

        // ОБНОВЛЯЕМ ОБЩИЙ СЧЕТЧИК
        $total_count = 0;
        foreach ($session_data['cart'] as $qty) {
            $total_count += $qty;
        }
        $session_data['cart_count'] = $total_count;

        // Сохраняем обратно в сессию
        $this->session->data = $session_data;

        $json['success'] = 'Товар добавлен!';
        $json['total'] = $total_count; // Передаем в JS новое общее число

        $this->response->setOutput(json_encode($json));
    }

    public function remove() {
        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];

            $session_data = $this->session->data;

            if (isset($session_data['cart'][$product_id])) {
                unset($session_data['cart'][$product_id]);
            }

            // ПЕРЕСЧИТЫВАЕМ СЧЕТЧИК ПОСЛЕ УДАЛЕНИЯ
            $total_count = 0;
            foreach ($session_data['cart'] as $qty) {
                $total_count += $qty;
            }
            $session_data['cart_count'] = $total_count;

            $this->session->data = $session_data;
        }

        // Редирект обратно в корзину
        $this->response->redirect('index.php?route=checkout/cart');
    }


}
