<?php
require_once("PDOConnexion.php");

class Stores implements JsonSerializable
{
    private $store_id;
    private $store_name;
    private $phone;
    private $email;
    private $street;
    private $city;
    private $state;
    private $zip_code;

    public function __construct(array $t = array())
    {
        foreach ($t as $k => $v) {
            $this->$k = $v;
        }
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function getAll()
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM stores";
        $sth = $db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Stores");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getStoreFromId($id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM stores WHERE store_id = :id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Stores");
        $sth->execute();
        return $sth->fetch();
    }

    public static function getProductsInStore($store_id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT p.* FROM products p INNER JOIN stocks s ON p.product_id = s.product_id WHERE s.store_id = :store_id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":store_id", $store_id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        $sth->execute();
        return $sth->fetchAll();
    }
}
