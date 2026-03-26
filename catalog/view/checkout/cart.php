<?php echo $header; ?>
<div class="container cart-page" style="margin-top: 30px;">
    <h1>Ваша корзина</h1>

    <?php if ($products) { ?>
        <table class="cart-table" style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr style="border-bottom: 2px solid #eee; text-align: left;">
                <th>Фото</th>
                <th>Наименование</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Итого</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><img src="<?php echo $product['thumb']; ?>" alt=""></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['quantity']; ?> шт.</td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['total']; ?></td>

                    <!-- ВОТ ЭТА ССЫЛКА ВЫЗЫВАЕТ МЕТОД REMOVE -->
                    <td style="text-align: center;">
                        <a href="index.php?route=checkout/cart/remove&product_id=<?php echo $product['product_id']; ?>"
                           class="btn-remove"
                           title="Удалить"
                           >
                            ❌
                        </a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>

        <div class="cart-total" style="text-align: right; margin-top: 20px; font-size: 20px;">
            <!-- Сделай так -->
            <strong>Итого к оплате: <?php echo $total_price; ?></strong>
        </div>
    <?php } else { ?>
        <p>Ваша корзина пуста.</p>
    <?php } ?>
</div>
<?php echo $footer; ?>
