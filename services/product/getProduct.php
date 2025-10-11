<?php
function getProductById($product_id)
{
    global $mysqli;
    if ($product_id === false) {
        die("Invalid input on request");
    }
    $query = "SELECT * FROM `products` WHERE `id` = ?;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $product = $result->fetch_assoc();
            return $product;
        } else {
            die("product with id " . $product_id . " not found");
        }
    } else {
        die("query failed");
    }
}
