<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <?php foreach ($styles as $style) { ?>
        <link rel="stylesheet" href="<?php echo $style; ?>?v=<?php echo time(); ?>">
    <?php } ?>
</head>
<body>
<header class="main-header">
    <div class="container header-flex">
        <div class="logo">
            <h1><a href="index.php?route=common/home">Orcart</a></h1>
        </div>

        <div class="header-cart">
            <a href="index.php?route=checkout/cart" class="cart-container">
                <span class="cart-icon">🛒</span>
                <span class="cart-text">Корзина</span>
                <span id="cart-total-count"><?php echo $cart_total; ?></span>
            </a>
        </div>
    </div>
</header>