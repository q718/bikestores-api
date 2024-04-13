<?php

final class PDOConnexion
{
    //Instance de la class PDOConnexion
    private static $instance;
    private static $type = "mysql";
    private static $host = "mysql-etu.unicaen.fr";
    private static $dbname = null;
    private static $user = null;
    private static $pwd = null;
    private $dbh = null;
    private function __construct()
    {
        try {
            if (is_null(self::$dbname) or is_null(self::$user) or is_null(self::$pwd))
                throw new Exception("Connexion impossible, paramètres absents");
            $this->dbh = new PDO(
                self::$type . ':host=' . self::$host . '; dbname=' . self::$dbname,
                self::$user,
                self::$pwd,
                array(PDO::ATTR_PERSISTENT => true)
            );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $req = "SET NAMES UTF8";
            $result = $this->dbh->prepare($req);
            $result->execute();
        } catch (PDOException $e) {
            echo "<p>Erreur !: " . $e->getMessage() . "</p>";
            die();
        }
    }
    public function __destruct()
    {
        if (!is_null($this->dbh)) {
            $this->dbh = null;
            self::$instance = null;
        }
    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PDOConnexion();
            return self::$instance->dbh;
        } else return self::$instance->dbh;
    }
    public static function setParameters($_dbname, $_user, $_pwd)
    {
        self::$dbname = $_dbname;
        self::$user = $_user;
        self::$pwd = $_pwd;
    }
}

PDOConnexion::setParameters("TABLE", "LOGIN", "PASSWORD");
