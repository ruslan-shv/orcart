<?php echo $header; ?>
<div class="container category-page">
    <aside class="column-left"><?php echo $menu; ?></aside>

    <main class="column-center">
        <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a> / </li>
            <?php } ?>
        </ul>

        <div class="product-info-layout" style="display: flex; gap: 40px;">
            <div class="product-image" style="flex: 1;">
                <img src="<?php echo $image; ?>" alt="<?php echo $heading_title; ?>" style="width: 100%; border-radius: 10px;">
            </div>

            <div class="product-details" style="flex: 1;">
                <h1><?php echo $heading_title; ?></h1>
                <div class="price" style="font-size: 24px; color: #e74c3c; font-weight: bold; margin: 20px 0;">
                    <?php echo $price; ?> ₽
                </div>
                <!-- Кнопка с ID товара -->
                <div class="cart-control">
                    <button type="button"
                            class="btn-buy button-cart-ajax"
                            data-product-id="<?php echo $product_id; ?>"
                            style="padding: 10px 20px;">
                        В корзину
                    </button>
                </div>
                <div class="description" style="margin-top: 30px; line-height: 1.6;">
                    <h3>Описание</h3>
                    <?php echo $description; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php echo $footer; ?>
