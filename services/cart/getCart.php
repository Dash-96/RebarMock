<?php
function getCart($user_id)
{
    global $mysqli;
    $active = 1;
    $cart_id = 0;
    if (!isset($user_id)) {
        http_response_code(401);
        echo json_encode(["error" => "no user id in session"]);
        exit;
    }
    $query = "SELECT `id` FROM `carts` WHERE `userId` = ? AND `is_active` = ?;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $user_id, $active);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $cart_id = $row['id'];
        } else {
            $query = "INSERT INTO `carts` (`userId`) VALUES (?);";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                $cart_id = $mysqli->insert_id;
            }
        }
        return ($cart_id);
    }
}