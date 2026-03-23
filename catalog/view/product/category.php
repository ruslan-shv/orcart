<?php echo $header; ?>

<div class="container category-page">
    <!-- ЛЕВАЯ КОЛОНКА -->
    <aside class="column-left">
        <?php echo $menu; ?>
    </aside>

    <!-- ПРАВАЯ КОЛОНКА -->
    <main class="column-center">

    <ul class="breadcrumb">
        <?php
        $count = count($breadcrumbs);
        foreach ($breadcrumbs as $i => $breadcrumb) {
            ?>
            <li class="breadcrumb-item">
                <?php if ($i + 1 < $count) { ?>
                    <!-- Для всех, кроме последнего — ссылка -->
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                    <span class="separator">/</span>
                <?php } else { ?>
                    <!-- Для последнего — просто текст (активный пункт) -->
                    <span class="active"><?php echo $breadcrumb['text']; ?></span>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>


    <h1><?php echo $heading_title; ?></h1>

    <!-- Список подкатегорий (если есть) -->
    <?php if ($categories) { ?>
        <div class="category-list" style="margin-bottom: 30px; display: flex; gap: 15px;">
            <?php foreach ($categories as $category) { ?>
                <a href="<?php echo $category['href']; ?>" class="btn-category" style="padding: 10px; border: 1px solid #ccc; text-decoration: none; border-radius: 5px;">
                    <?php echo $category['name']; ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>

    <!-- Сетка товаров (как на главной) -->
    <?php if ($products) { ?>
        <div class="product-grid">
            <?php foreach ($products as $product) { ?>
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
    <?php } else { ?>
        <p>В этой категории пока нет товаров.</p>
    <?php } ?>
    </main>
</div>

<?php echo $footer; ?>
