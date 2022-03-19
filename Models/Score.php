<?php

/* Appel de script permettant accès à la BDD*/
include_once("bdd.php");


/*
Création de classe avec fonctions statiques
App limitée à deux opérations simples, donc pas besoin d'Accesseurs/Mutateurs (getters/setters)


function(){
    Instance de connexion à la BDD
    Requête SQL (sans & avec paramètres (+ sécurisé car données provenant du côté client))
    Execution
}
*/
class Score
{
    /**
     * @return array
     */
    public static function findThreeBest(): array
    {
        $pdo = Bdd::getInstance();
        $sql = "SELECT *
    FROM `score` ORDER BY `score_time` ASC LIMIT 3";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * @param string $nickname
     * @param string $time
     * @return void
     */
    public static function addScore(string $nickname, string $time): void
    {
        $pdo = Bdd::getInstance();
        $sql = "INSERT INTO `score` (`score_nickname`, `score_time`) VALUES (:nickname, :time)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);
        $stmt->bindValue(':time', $time, PDO::PARAM_STR);
        $stmt->execute();
    }
}
