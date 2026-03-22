<?php


require_once('config.php');
require_once(DIR_CORE . 'engine/autoloader.php');

$registry = new Registry();

$action = new Action();
$action->execute($registry);
$seo = $registry->get('seourl');
$seo->rewrite();

$response = $registry->get('response');
$response->output();