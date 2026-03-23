<aside class="side-menu">
    <h3>Каталог</h3>
    <ul>
        <?php foreach ($categories as $category) { ?>
            <li>
                <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                <?php if ($category['children']) { ?>
                    <ul class="sub-menu">
                        <?php foreach ($category['children'] as $child) { ?>
                            <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</aside>
