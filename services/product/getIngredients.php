<?php
function getIngredients()
{
    global $mysqli;
    $query = "SELECT * FROM `ingredients`;";
    $result = $mysqli->query($query);
    if ($result) {
        $response = [];
        while ($row = $result->fetch_assoc()) {
            $index = 0;
            $response[] = $row;
            $index++;
        }
        return ($response);
    }
}
