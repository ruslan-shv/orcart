<?php echo $header; ?>

<div class="container category-page">
    <!-- ЛЕВАЯ КОЛОНКА (Меню) -->
    <aside class="column-left">
        <?php echo $menu; ?>
    </aside>
        <main class="column-center">
            <h2>Новинки</h2>
                <div class="product-grid">
                    <?php foreach ($latest as $product) { ?>
                        <div class="product-card">
                            <div class="image text-center">
                                <img src="<?php echo $product['thumb'] ?: 'no-image.png'; ?>" alt="" style="max-width:100%">
                            </div>
                            <a href="<?php echo $product['href']; ?>">
                                <h4><?php echo $product['name']; ?></h4>
                            </a>

                            <div class="price"><?php echo number_format($product['price'], 0, '.', ' '); ?> ₽</div>
                            <!-- Кнопка с ID товара -->
                            <div class="cart-control">
                                <button type="button"
                                        class="btn-buy button-cart-ajax"
                                        data-product-id="<?php echo $product['product_id']; ?>"
                                        style="padding: 10px 20px;">
                                    В корзину
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
        </main>
</div>


<?php echo $footer; ?>