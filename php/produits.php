<?php

require_once ("utils/db_connect.php");

$req = $db->prepare("SELECT * FROM product");

$req->execute();

$produits = $req->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["produits" => $produits]);



