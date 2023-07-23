<?php

$host = "localhost"; // localhost
$username = "root"; // Nom de l'utilisateur (root)
$password = ""; // Mots de passe de l'utilisateur root
$dbname = "projet"; // Nom de la base de donnees

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
   //   echo "Connexion ok"; 
} catch (ErrorException $e) {
    echo $e;    
}

?>