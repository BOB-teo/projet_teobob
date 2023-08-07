<?php


session_start(); // $_SESSION


require_once("utils/db_connect.php");

// if email, pwd !$_POST = false
if (!isset($_POST["email"], $_POST["pwd"])) {
    echo json_encode(["success" => false, "error" => "Données manquantes"]);
    die;
}

if (empty(trim($_POST["email"])) || empty(trim($_POST["pwd"]))) {
    echo json_encode(["success" => false, "error" => "Données vides"]);
    die; 
}

// Requête séléctionner données de l'utilisateur
$req = $db->prepare("SELECT * FROM users WHERE email = ?");
$req->execute([$_POST["email"]]);

// J'affecte à ma variable $user le résultat unique (ou pas de résultat) de ma requete SQL
$user = $req->fetch(PDO::FETCH_ASSOC);

// if = variable $user à une valeur ET que le mot de passe correspond au hash de celui de l'utilisateur alors
if ($user && password_verify($_POST["pwd"], $user["pwd"])) {
    $_SESSION["connected"] = true; 
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["admin"] = $user["admin"];

    // Retirer hash dans $user
    unset($user["pwd"]);

    echo json_encode(["success" => true, "user" => $user]);
} else {
    
    $_SESSION = [];
    session_destroy();

    echo json_encode(["success" => false, "error" => "Aucun utilisateur"]);
}
