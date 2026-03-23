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
                                <img src="image/<?php echo $product['image'] ?: 'no-image.png'; ?>" alt="" style="max-width:100%">
                            </div>
                            <h4><?php echo $product['name']; ?></h4>
                            <div class="price"><?php echo number_format($product['price'], 0, '.', ' '); ?> ₽</div>
                            <button class="btn-buy">В корзину</button>
                        </div>
                    <?php } ?>
                </div>
        </main>
</div>


<?php echo $footer; ?>