<?php

require_once ("../utils/db_connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") $method = $_POST;
else $method = $_GET;

switch ($method["choice"]) {
    case 'delete':

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
            die; 
        }

        $req = $db->prepare("DELETE FROM product WHERE id_product = ?");
        $req->execute([$method["id"]]);

        //? Si j'ai 1 résultat avec c'est un succès
        if ($req->rowCount()) echo json_encode(["success" => true]);
        //? Sinon
        else echo json_encode(["success" => false, "error" => "Erreur lors de la suppression"]);

        break;

        default:
        //! Aucune case ne correspond à mon choix
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Ce choix n'existe pas"]);
        break;
}