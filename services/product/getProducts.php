<?php
function getProducts()
{
    global $mysqli;
    if (!isset($mysqli)) {
        echo "mysqli not initialized";
    }
    $query = "SELECT * FROM `products`;";
    $result = $mysqli->query($query);
    $response = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {

            $response[] = array('id' => $row['id'], "name" => $row['name'], "ingredients" => $row['ingredients'], "category" => $row['category'], "image" => $row['image_uri']);
        }
        return $response;
    }
}
