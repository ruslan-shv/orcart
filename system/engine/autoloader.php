<?php

// 2. Автозагрузка классов (минимальная реализация)
spl_autoload_register(function ($class) {
	$directories = [
        'engine/',
        'library/'
    ];
	
	foreach ($directories as $directory) {
        $file = DIR_SYSTEM .  $directory . strtolower($class) . '.php';
        
        if (is_file($file)) {
            require_once($file);
            return true; // Останавливаем поиск, если файл найден
        }
    }
    return false;
});
