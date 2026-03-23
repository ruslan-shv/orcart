<?php


require_once('config.php');
require_once(DIR_CORE . 'engine/autoloader.php');

$registry = new Registry();
$seo = $registry->get('seourl');
$seo->rewrite();
$registry->set('url', $seo);

$route = isset($_GET['route']) ? (string)$_GET['route'] : 'common/home';
$action = new Action($route);

$action->execute($registry);


$response = $registry->get('response');
$response->output();