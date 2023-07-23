<?php

session_start();

function isConnected()
{
    //? Si la clé "connected" n'existe pas dans la superglobale SESSION OU que la valeur de "connected" dans la superglobale SESSION n'est pas vrai alors
    if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
        // J'envoie une réponse avec un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Vous n'êtes pas connecté"]);
        die; //! J'arrête l'execution du script
    }
}


?>