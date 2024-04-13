<?php
require_once("PDOConnexion.php");

class Brands implements JsonSerializable
{
    private $brand_id;
    private $brand_name;

    public function __construct(array $t = array())
    {
        foreach ($t as $k => $v) {
            $this->$k = $v;
        }
    }

    public function __get($brand_id)
    {
        return $this->$brand_id;
    }

    public function __set($brand_id, $v)
    {
        $this->$brand_id = $v;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function getAll()
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM brands";
        $sth = $db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Brands");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getBrandFromId($id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM brands WHERE brand_id = :id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Brands");
        $sth->execute();
        return $sth->fetch();
    }
}
