<?php

require_once ("utils/db_connect.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;

switch ($method["choice"]) {
    case 'select':
        
        $req = $db->query("SELECT * FROM product");

        $produits = $req->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["produits" => $produits]);

        break;

    case 'delete':

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
            die; 
        }

        $req = $db->prepare("DELETE FROM product WHERE id_product = ?");
        $req->execute([$method["id"]]);

        echo ($req->rowCount());

        echo json_encode(["success" => true]);

        break;
}