<footer class="container mt-5 py-3 border-top">
    <p class="text-center text-muted"><?php echo $text_powered; ?></p>
</footer>

<!-- Сюда можно будет подключать JS скрипты --><!-- JS обработчик -->
<script>
    document.addEventListener('click', function(e) {
        // Проверяем, что нажали именно на кнопку добавления
        if (e.target && e.target.classList.contains('button-cart-ajax')) {
            const productId = e.target.getAttribute('data-product-id');
            const quantity = 1; // В каталоге обычно добавляют по 1 шт.

            fetch('index.php?route=checkout/cart/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${productId}&quantity=${quantity}`
            })
                .then(response => response.json())
                .then(json => {
                    if (json['success']) {
                        // Обновляем счетчик в шапке (наш старый код)
                        const badge = document.querySelector('#cart-total-count');
                        if (badge) {
                            badge.textContent = json['total'];
                            badge.style.display = 'flex';

                            // Эффект пульсации
                            badge.animate([
                                { transform: 'scale(1)' },
                                { transform: 'scale(1.4)' },
                                { transform: 'scale(1)' }
                            ], { duration: 250 });
                        }

                        // Опционально: меняем текст кнопки на "Добавлено!" на секунду
                        const originalText = e.target.textContent;
                        e.target.textContent = '✓ Добавлено';
                        e.target.style.background = '#218838';
                        setTimeout(() => {
                            e.target.textContent = originalText;
                            e.target.style.background = '';
                        }, 1500);
                    }
                });
        }
    });
</script>

</body>
</html>
