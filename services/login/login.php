<?php
require_once BASE_PATH . ("/inputValidater.php");
session_start();
//validatePostRequest();
function login()
{
    global $mysqli;
    $action = $_POST['action'];
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $user_id = 0;
    $user_email = "";
    $user_pass = "";
    $query = "SELECT * from `users` WHERE `email` = ?;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row['id'];
            $user_email = $row['email'];
            $user_pass = $row['password'];
        }
    }
    switch ($action) {
        case "login":
            if ($email == $user_email) {
                if (password_verify($password, $user_pass)) {
                    $_SESSION['user_id'] = $user_id;
                    return "success";
                } else {
                    return "Incorrect Password";
                }
            } else {
                return "Incorrect email";
            }
            break;
        case "sign-up":
            if ($email == $user_email) {
                return "duplicate";
                die();
            }
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO `users` (`email`, `password`) VALUES(?,?);";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ss", $email, $hashed_pass);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $mysqli->insert_id;
                return "success";
            } else {
                return "failed";
            }
            break;
    }
}
