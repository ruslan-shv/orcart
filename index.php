<?php
// 1. Константы путей (в OC они обычно в config.php)
define('DIR_APPLICATION', __DIR__ . '/catalog/');
define('DIR_SYSTEM', __DIR__ . '/system/');
define('DIR_STORAGE', __DIR__ . '/storage/');

require_once(DIR_SYSTEM . 'engine/autoloader.php');

$registry = new Registry();

$action = new Action();
$action->execute($registry);


if (isset($_GET['debug'])) {
    echo '<pre style="background:#eee; padding:10px; border:1px solid #ccc;">';
    print_r($registry->get('profiler')->getMetrics());
    echo '</pre>';
}