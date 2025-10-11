<?php

Flight::group('/api/V1', function () {
    Flight::group('/product', function () {
        Flight::route('GET /', function () {
            include  BASE_PATH  . '/services/product/getProducts.php';
            $response = getProducts();
            Flight::json($response);
        });

        Flight::route('GET /ingredients', function () {
            include BASE_PATH . '/services/product/getIngredients.php';
            $ingredients = getIngredients();
            Flight::json($ingredients);
        });

        Flight::route('GET /@id', function ($id) {
            include BASE_PATH . '/services/product/getProduct.php';
            $product_id = (int)$id;
            $product = getProductById($product_id);
            if ($product) {
                Flight::json($product);
            } else {
                Flight::json(["error" => "product with id $id not found"], 404);
            }
        });
    });

    Flight::route('POST /login', function () {
        include BASE_PATH  . '/services/login/login.php';
        $data  = Flight::request()->data->getData();
        $response = login($data);
        Flight::json(["response" => $response]);
    });

    Flight::group('/cart', function () {
        Flight::route('POST /cartItem', function () {
            include BASE_PATH . '/services/cart/addCartItem.php';
            $data = Flight::request()->data->getData();
            $response = addCartItem($data);
            if ($response) Flight::json(["response" => $response]);
            else Flight::json(["error" => "Failed to add item"], 400);
        });
    });
});
