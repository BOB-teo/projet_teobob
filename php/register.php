<?php


require_once("utils/db_connect.php");


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
    die;
}

if (empty(trim($_POST["firstname"])) || empty(trim($_POST["lastname"])) || empty(trim($_POST["birthdate"])) || empty(trim($_POST["email"])) || empty(trim($_POST["pwd"]))) {
    echo json_encode(["success" => false, "error" => "Données vides"]);
    die; 
}

$regex = "/^[a-zA-Z0-9-+._]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}$/";
// Si email ne correspond pas alors
if (!preg_match($regex, $_POST["email"])) {
    // J'envoie success false 
    echo json_encode(["success" => false, "error" => "Email au mauvais format"]);
    die; 
}


// Je hash le mot de passe avec la méthode par défaut
$hash = password_hash($_POST["pwd"], PASSWORD_DEFAULT);

// Requete pour nouveaux utilisateur
$req = $db->prepare("INSERT INTO users(firstname, lastname, birthdate, email, pwd) VALUES (:firstname, :lastname, :birthdate, :email, :pwd)");
// J'affecte à chaque clé les valeurs correspondantes grâce au bindValue
$req->bindValue(":firstname", $_POST["firstname"]);
$req->bindValue(":lastname", $_POST["lastname"]);
$req->bindValue(":birthdate", $_POST["birthdate"]);
$req->bindValue(":email", $_POST["email"]);
$req->bindValue(":pwd", $hash);
$req->execute();

if ($req->rowCount()) echo json_encode(["success" => true]);
else echo json_encode(["success" => false, "error" => "Mail déjà existant"]);


