<?php
class Registry {
    private $data = [];
    private $available_classes = [];
	private $aliases = [
		'loader' => 'load',
    ];


    public function __construct() {
        // Сканируем папку library и запоминаем, какие классы у нас есть
        $files = glob(DIR_CORE . 'library/*.php');
        foreach ($files as $file) {
			$filename = strtolower(basename($file, '.php'));
            if ($filename == 'registry') continue;
			if(isset($this->aliases[$filename])) {
				$alias = $this->aliases[$filename];
				$this->available_classes[$alias] = $filename;
			} else {
				$this->available_classes[$filename] = $filename;
			}

        }
    }

    public function get($key) {
        $key = strtolower($key);

        // Если объекта еще нет, но класс существует в library — создаем его
        if (!isset($this->data[$key]) && isset($this->available_classes[$key])) {
            $class_name = $this->available_classes[$key];
            
            // Нюанс: некоторым классам (как Loader или DB) нужен $registry в конструктор
            // Для простоты проверяем через Reflection или просто передаем везде
            $this->data[$key] = new $class_name($this); 
            
            if (method_exists($this->data[$key], 'setRegistry')) {
                $this->data[$key]->setRegistry($this);
            }
        }

        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function set($key, $value) {
        $this->data[strtolower($key)] = $value;
    }
}