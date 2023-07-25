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

function upload($file)
{
    //? Si une image est transmise via le formulaire alors
    if (isset($file["img"]["name"])) {
        //* Récupération du nom de fichier dans la superglobale FILES
        $filename = $file["img"]["name"];

        $name = explode(".", $filename);

        $time = strval(time()); // Time() = Nombre de secondes depuis le début du 1er janvier 1970 a 00:00:00.

        $new_name = $name[0] . $time . "." . $name[1];

        $location = __DIR__ . "/../../img/" . $new_name;

        //* Récupération de l'extension du fichier
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        //* Transformation de l'extension en minuscule
        $extension = strtolower($extension);


        $valid_extensions = ["jpg", "jpeg", "png", "webp"];

        //? Si l'extension du fichier appartient au tableau des extensions valides alors
        if (in_array($extension, $valid_extensions)) {
            
            if (move_uploaded_file($file["img"]["tmp_name"], $location)) {
            return $new_name;
            }
            else return false;
        } else return false;
    } else return false;
}

