<?php
//! Permet l'affichage des erreurs - A ne pas commit
error_reporting(-1);

//? J'intègre le contenu du fichier de connexion à ma bdd dans mon fichier actuel
require_once("utils/db_connect.php");

// J'intègre obligatoirement le contenu de mon fichier mailer
// require("utils/mailer.php");

//? Si ma méthode de requête est différente de POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Mauvaise méthode"]);
    die;
}

//? Si mes paramètres nécessaires à l'inscription n'existent pas alors
if (!isset($_POST["firstname"], $_POST["lastname"], $_POST["birthdate"], $_POST["email"], $_POST["pwd"])) {
    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Données manquantes"]);
    die; //! J'arrête l'exécution du script
}

//? Si au moins un des paramètres est vide alors
if (
    empty(trim($_POST["firstname"])) ||
    empty(trim($_POST["lastname"])) ||
    empty(trim($_POST["birthdate"])) ||
    empty(trim($_POST["email"])) ||
    empty(trim($_POST["pwd"]))
) {
    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Données vides"]);
    die; //! J'arrête l'exécution du script
}

$regex = "/^[a-zA-Z0-9-+._]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}$/";
//? Si mon email ne correspond pas à l'ER alors
if (!preg_match($regex, $_POST["email"])) {
    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Email au mauvais format"]);
    die; //! J'arrête l'exécution du script
}

$regex = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])[a-zA-Z0-9]{8,12}$/";
//? Si mon mot de passe ne correspond pas à l'ER alors
if (!preg_match($regex, $_POST["pwd"])) {
    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Mot de passe au mauvais format"]);
    die; //! J'arrête l'exécution du script
}

// Je hash le mot de passe avec la méthode par défaut
$hash = password_hash($_POST["pwd"], PASSWORD_DEFAULT);

// J'écris la requete préparée d'insertion du nouvel utilisateur
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

// mailer($_POST["email"], "Bienvenue {$_POST["firstname"]}", "Merci pour inscription");
