<?php
require_once BASE_PATH . "/includes/auth.php";
require_once BASE_PATH . "/services/product/getProducts.php";
//require_login();
//echo $_SESSION['user_id'];
$products  = getProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/rebarMock/rebarClone.css">
    <link rel="stylesheet" href="/rebarMock/Pages/product/productsMenu.css">
    <title>Document</title>
</head>

<body>
    <div style="display:flex; justify-content:center; width:100%;">
        <div class="menu-container">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img height="100" width="70" src="http://localhost/rebarMock/<?= $product['image'] ?>"
                    alt="<?= $product['name'] ?> image">
                <span class="seperator"></span>
                <span class="product-title"><?= $product['name'] ?></span>
                <span><?= $product['ingredients'] ?></span>
                <a href="http://localhost/rebarMock/menu/product/<?= $product['id'] ?>"><button
                        class="add-product-btn">הוספת מוצר</button></a>
            </div>
            <?php endforeach ?>
        </div>
    </div>

    <script>
    function handleProductSelect() {

    }
    </script>
</body>

</html>