<?php

session_start();

function isConnected()
{
    if (!isset($_SESSION["connected"]) || !$_SESSION["connected"]) {
        // J'envoie un success false et un message d'erreur
        echo json_encode(["success" => false, "error" => "Vous n'êtes pas connecté"]);
        die;
    }
}

function upload($file)
{
    // image de "form"
    if (isset($file["img"]["name"])) {

        $filename = $file["img"]["name"];

        $name = explode(".", $filename);

        $time = strval(time()); // Time() = Nombre de secondes depuis le début du 1er janvier 1970 a 00:00:00.

        $new_name = $name[0] . $time . "." . $name[1];

        $location = __DIR__ . "/../../img/" . $new_name;

        //* l'extension du fichier
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        //* l'extension en minuscule
        $extension = strtolower($extension);


        $valid_extensions = ["jpg", "jpeg", "png", "webp"];

        // l'extension appartient au tableau des extensions valides alors
        if (in_array($extension, $valid_extensions)) {
            
            if (move_uploaded_file($file["img"]["tmp_name"], $location)) {
            return $new_name;
            }
            else return false;
        } else return false;
    } else return false;
}

