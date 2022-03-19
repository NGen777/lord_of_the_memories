<?php

/*
Appel de Scripet permmettant l'accès à la Classe Score
 */
include_once("Models/Score.php");

/*
Liste des Headers (entêtes HTTP) nécessaires au bon fonctionnement de l'API
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


/*
Vérification de la méthode d'appel
Récupération des données Json & conversion en PHP
Ajout à la BDD avec vérifications de sécurité car données reçues du côté client
*/
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $content = trim(file_get_contents("php://input"));
    $data = json_decode($content, true);

    Score::addScore(strip_tags((string)$data['nickname']), strip_tags((string)$data['time']));

    http_response_code(202);
    echo json_encode($data);

}else{
    /* Gestion SI mauvaise méthode */
    http_response_code(405);
    echo json_encode(["message" => "Méthode POST requise"]);
}