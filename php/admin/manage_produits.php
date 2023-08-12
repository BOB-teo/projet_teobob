<?php

require_once ("../utils/db_connect.php");


require("../utils/function.php");



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

        echo ($method["img"]);

        $response = [];

        if ($req->rowCount())  {
            $location = __DIR__ . "/../../img/" . $method["img"];
            unlink($location);  
            $response["success"] = "img supprimée";
        } else {
            $response["success"] = false;
            $response["error"] = "Erreur lors de la suppression";
        }

echo json_encode($response);


        break;

        default:
        // Aucune case ne correspond à mon choix
        echo json_encode(["success" => false, "error" => "Ce choix n'existe pas"]);

        break;

        case 'insert':

         if ($_SERVER["REQUEST_METHOD"] != "POST") {
             echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
             die;
         }

         if (!isset($method["name"], $method["desc"]) || empty(trim($method["name"])) || empty(trim($method["desc"]))) {
             echo json_encode(["success" => false, "error" => "Données manquantes"]);
             die;
         }

        $img = false;
        if (isset($_FILES["img"]["name"])) $img = upload($_FILES);
        
        $req = $db->prepare("INSERT INTO product(product_name, product_description, product_image, product_price) VALUES (:name, :desc, :img, :price)");
        
        $req->bindValue(":name", $method["name"]);
        $req->bindValue(":desc", $method["desc"]);
        $req->bindValue(":price", $method["price"]);    
        if ($img) $req->bindValue(":img", $img);
        else $req->bindValue(":img", null);
        $req->execute();

        echo json_encode(["success" => true]);

        // $article_id = $db->lastInsertId(); //! Faire des test/voir ce qu'il se passe 

        break; 

        case 'update':
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
                die;
            }
    
            if (!isset($method["name"], $method["desc"]) || empty(trim($method["name"])) || empty(trim($method["desc"]))) {
                 echo json_encode(["success" => false, "error" => "Données manquantes"]);
                 die;
            }

            $img = false;
    
            if (isset($_FILES["img"]["name"]) && $_FILES["img"]["name"] != null) $img = upload($_FILES);
            

            $img_req = ''; 
            if ($img) $img_req = ", product_image = :img"; // S'il y a image d'upload lors de la maj alors $img_req
    
            // requete mise à jour du produit
            $req = $db->prepare("UPDATE product SET product_name = :name, product_description = :desc, product_price = :price $img_req WHERE id_product = :id");
            
            // J'affecte clé valeurs -> bindValue
            $req->bindValue(":name", $method["name"]);
            $req->bindValue(":desc", $method["desc"]);
            $req->bindValue(":price", $method["price"]);
            $req->bindValue(":id", $method["id"]);
            if ($img) $req->bindValue(":img", $img);
            $req->execute();

            // if (isset($method["old_img"]) && $method["old_img"] != null) {
            //     $location = __DIR__ . "/../../img/" . $method["old_img"];
            //     unlink($location);
            // }

            echo json_encode(["success" => true]);
    
            break;

}