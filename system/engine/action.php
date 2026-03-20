<?php
class Action {
    private $id;
    private $route;
    private $method = 'index';

    public function __construct($route = 'common/home') {
		$this->route = $route;
		
        $this->id = $route;

        $parts = explode('/', str_replace('../', '', (string)$route));

        // Разбиваем роут на части. Если в роуте больше 2 частей, 
        // последняя обычно считается методом класса.
        // Пример: 'checkout/cart/add' -> файл checkout/cart.php, метод add()
        while ($parts) {
            $file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';

            if (is_file($file)) {
                $this->route = implode('/', $parts);
                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    public function execute($registry, array $args = array()) {
        $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->route);
        $file = DIR_APPLICATION . 'controller/' . $this->route . '.php';

        if (is_file($file)) {
            include_once($file);

            $controller = new $class($registry);

            // Проверяем, можно ли вызвать метод (по умолчанию index)
            if (is_callable(array($controller, $this->method))) {
                return call_user_func(array($controller, $this->method), $args);
            } else {
                return new \Exception('Ошибка: Не удалось вызвать метод ' . $this->method . '!');
            }
        } else {
            return new \Exception('Ошибка: Не удалось найти контроллер ' . $this->route . '!');
        }
    }
}