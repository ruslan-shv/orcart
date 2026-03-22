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
<header>
    <div class="container">
        <h1>Orcart</h1>
    </div>
</header>
