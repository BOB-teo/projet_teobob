<?php

require_once("utils/db_connect.php");

$id = $_GET["id"];

$requestsql = $db->query("SELECT * FROM product WHERE id_product = $id");

$produit_id = $requestsql->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["produit_id" => $produit_id]);