<?php
require '../../bootloader.php';

$nav = nav();

if (is_logged_in()) {
    $user_key = is_logged_user();
    $rows = file_to_array(DB_FILE);

    $h3 = 'Sveiki sugrize' . ' ' . $_SESSION['email'] . ' Jus pridejote ' .  $rows['users'][$user_key]['items'] . ' prekiu';
} else {
    $h3 = 'Jus neprisijunges';
}

$products_array = file_to_array(DB_FILE);
$products = [];
foreach ($products_array['items'] as $items){
    if ($items['email'] === $_SESSION['email']) {
        $products[] = $items;
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Shop</title>
</head>
<body>
<main>
    <?php require ROOT . '/app/templates/nav.tpl.php'; ?>
    <article class="wrapper">
        <h1 class="header header--main">Welcome to BBZ SHOP</h1>
        <h3 class="header"><?php print $h3; ?></h3>
        <section class="grid-container">
            <?php foreach ($products as $product) : ?>
                <div class="grid-item">
                    <h4><?php print $product['name']; ?></h4>
                    <img class="product-img" src="<?php print $product['img']; ?>" alt="">
                    <p><?php print $product['descrip']; ?></p>
                    <p><?php print $product['price']; ?> $</p>
                </div>
            <?php endforeach; ?>
        </section>
    </article>
</main>
</body>
</html>