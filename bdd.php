<?php

/*
Classe permettant accès à la BDD
Pattern Singleton évitant de multiples connexions ouvertes à la BDD
Extension de la classe PDO (native PHP)
*/ 


class Bdd extends PDO
{
    private static $instance;

    /*
    Déclaration des constantes pour plus de malléabilité (ex: pratique quand changement d'environnement)
    */
    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'lotm';


    /*
    Tentative de connexion, si échec alors envoi du message d'erreur correspondant
    */
    private function __construct()
    {
        $_dsn = 'mysql:dbname='. self::DBNAME . ';host=' . self::DBHOST;

        try{
            /*
            Appel du constructeur de la classe parent PDO
            Choix du contexte (options liées à la réception des données)
            */
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    /*
    Fonction permettant de renvoyer une instance si existe déjà, si non alors création de l'instance
    */
    public static function getInstance():self
    {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}