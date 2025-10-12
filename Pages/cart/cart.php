<?php
session_start();
include BASE_PATH . "/services/cart/getCart.php";
include BASE_PATH . "/services/cart/getCartItems.php";
include BASE_PATH . "/includes/token.php";
// include "../../config.php";
$base_url = "http://localhost/rebarMock/";
$user_data = decodeToken($_COOKIE['access_token']);
$user_id = $user_data->user_id;
$cart_id = getCart($user_id);
$cart_items = get_cart_items($cart_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rebarMock/rebarClone.css">
    <link rel="stylesheet" href="/rebarMock/pages/cart/cart.css">
    <title>Document</title>
</head>

<body>
    <div class="page-wraper">
        <?php foreach ($cart_items as $item): ?>
        <div class="cart-item">
            <img class="image" src="<?= $base_url . $item['image'] ?>">
            <div class="info-wraper">
                <span class="product-name"><?= $item['name'] ?></span>
                <span><?= $item['ingredients'] ?></span>
                <span>מחיר: <?= $item['price'] ?></span>
            </div>
            <div class="action-buttons-container">
                <button>ערוך</button>
                <button>הסר</button>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</body>

</html>