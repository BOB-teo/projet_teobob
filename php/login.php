<?php
//? Permet de démarrer la session sur ce fichier et donc d'utiliser la super globale $_SESSION
session_start();

//? J'intègre le contenu du fichier de connexion à ma bdd dans mon fichier actuel
require_once("utils/db_connect.php");

//? Si je n'ai pas les paramètres "email" et "pwd" dans ma superglobale $_POST alors
if (!isset($_POST["email"], $_POST["pwd"])) {
    echo json_encode(["success" => false, "error" => "Données manquantes"]);
    die;
}

//? Si les paramètres "email" et "pwd" dans ma superglobale $_POST sont vides alors
if (empty(trim($_POST["email"])) || empty(trim($_POST["pwd"]))) {
    echo json_encode(["success" => false, "error" => "Données vides"]);
    die; 
}

// J'écris ma requête préparée pour séléctionner toutes les données de l'utilisateur
$req = $db->prepare("SELECT * FROM users WHERE email = ?");
$req->execute([$_POST["email"]]);

// J'affecte à ma variable $user le résultat unique (ou pas de résultat) de ma requete SQL
$user = $req->fetch(PDO::FETCH_ASSOC);

//? Si ma variable $user à une valeur ET que le mot de passe correspond au hash de celui de l'utilisateur alors
if ($user && password_verify($_POST["pwd"], $user["pwd"])) {
    $_SESSION["connected"] = true; // J'affecte à la clé "connected" la valeur true
    $_SESSION["user_id"] = $user["id"]; // J'affecte à la clé "user_id" la valeur de l'id de l'utilisateur qui vient de se connecter
    $_SESSION["admin"] = $user["admin"];

    //! Je retire la donnée hash du mot de passe dans ma variable $user
    unset($user["pwd"]);

    // J'envoie une réponse avec un success true et les données de l'utilisateur
    echo json_encode(["success" => true, "user" => $user]);
} else {
    // Je vide ma session
    $_SESSION = [];
    session_destroy();

    // J'envoie une réponse avec un success false et un message d'erreur
    echo json_encode(["success" => false, "error" => "Aucun utilisateur"]);
}
