<?php
// include "../../../inputValidater.php";
include BASE_PATH . "/services/cart/getCart.php";
//include BASE_PATH . "/includes/token.php";
session_start();
//validatePostRequest();
function addCartItem($data, $user_id)
{
    global $mysqli;
    // if (!isset($user_id)) {
    //     $user_id = $_SESSION['user_id'];
    // }
    if ($data) {
        $cart_id = getCart($user_id);
        $product_id = $data['productId'];
        $product_price = $data['price'];
        $query = "INSERT INTO `cart_items` (`cartId`, `productId`, `price`) VALUES (?,?,?);";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iii", $cart_id, $product_id, $product_price);
        if ($stmt->execute()) {
            return "success";
        } else {
            return  "failed";
        }
    }
}