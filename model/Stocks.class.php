<?php
require_once("PDOConnexion.php");

class Stocks implements JsonSerializable
{
    private $stock_id;
    private $store_id;
    private $product_id;
    private $quantity;

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
        $sql = "SELECT * FROM stocks";
        $sth = $db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Stocks");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getStockFromId($id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM stocks WHERE stock_id = :id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Stocks");
        $sth->execute();
        return $sth->fetch();
    }

    public static function getStockFromStore($store)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM stocks INNER JOIN stores ON stocks.store_id = stores.store_id WHERE stocks.store_id = :store";
        $sth = $db->prepare($sql);
        $sth->bindValue(":store", $store, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Stocks");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getStockFromProduct($product)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM stocks INNER JOIN products ON stocks.product_id = products.product_id WHERE stocks.product_id = :product";
        $sth = $db->prepare($sql);
        $sth->bindValue(":product", $product, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Stocks");
        $sth->execute();
        return $sth->fetchAll();
    }
}
