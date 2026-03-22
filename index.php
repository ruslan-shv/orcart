<?php


require_once('config.php');
require_once(DIR_CORE . 'engine/autoloader.php');

$registry = new Registry();

$action = new Action();
$action->execute($registry);
$seo = $registry->get('seourl');
$seo->rewrite();

if (isset($_GET['debug'])) {
    echo '<pre style="background:#eee; padding:10px; border:1px solid #ccc;">';
    print_r($registry->get('profiler')->getMetrics());
    echo '</pre>';
}