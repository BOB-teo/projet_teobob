<?php

require_once("./utils/db_connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $method = $_POST;
}  else{
    $method = $_GET;
}

switch ($method["choice"]) {
    case 'select':

        $id_user = $_GET['id_user'];
        
        $requestsql = $db->prepare(
            "SELECT c.cart_id, c.id_user, c.id_product, p.product_name, p.product_price, p.product_image
             FROM cart c
             JOIN product p ON c.id_product = p.id_product
             WHERE c.id_user = $id_user");

        $requestsql->execute();

        $produits = $requestsql->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["produits" => $produits]);

        break;

        case 'insert':

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
                die;
            }

            $id_user = $_POST['id_user'];
            $id_product = $_POST['id_product'];

            $requestsql = $db->prepare("INSERT INTO cart (id_user, id_product) VALUES (:id_user, :id_product)");
            $requestsql->bindValue(':id_user', $id_user);
            $requestsql->bindValue(':id_product', $id_product);

            $requestsql->execute();

            echo json_encode(["success" => true]);

            break;

        case 'delete':

            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
                die; 
            }

            $cart_id = $_POST['id'];

            $requestsql = $db->prepare("DELETE FROM cart WHERE cart_id = ?");
            $requestsql->execute([$cart_id]);
            
            echo json_encode(["success" => true]);

            break;
}      