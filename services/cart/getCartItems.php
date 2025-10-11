<?php

function get_cart_items($cart_id)
{
    global $mysqli;
    $data = [];
    $query = "SELECT `products`.`image_uri` as `image`,`products`.`name`, `products`.`ingredients`, `cart_items`.`price`
    FROM `products` JOIN `cart_items` ON `products`.`id` = `cart_items`.`productId` 
    WHERE `cart_items`.`cartId` = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $cart_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
