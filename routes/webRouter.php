<?php


Flight::route('GET /', function () {
    echo 'Welcome to RebarMock!';
});
Flight::route('GET /menu', function () {
    include BASE_PATH . '/Pages/product/productsMenu.php';
});
Flight::route('GET /menu/product/@id', function ($id) {
    $product_id = (int)$id;
    include BASE_PATH . '/pages/product/productPage.php';
});
Flight::route('GET /login', function () {
    include  BASE_PATH . '/Pages/login/login.html';
});
Flight::route('GET /signup', function () {
    include  BASE_PATH . '/Pages/login/signup.html';
});
Flight::route('GET /cart', function () {
    include  BASE_PATH . '/Pages/cart/cart.php';
});
