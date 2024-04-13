<?php
require_once("PDOConnexion.php");

class Products implements JsonSerializable
{
    private $product_id;
    private $product_name;
    private $brand_id;
    private $category_id;
    private $model_year;
    private $list_price;

    public function __construct(array $t = array())
    {
        foreach ($t as $k => $v) {
            $this->$k = $v;
        }
    }

    public function __get($product_id)
    {
        return $this->$product_id;
    }

    public function __set($product_id, $v)
    {
        $this->$product_id = $v;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function getAll($brand = null, $category = null, $year = null, $price = null)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = array();

        if ($brand !== null) {
            $sql .= " AND brand_id IN (" . implode(",", $brand) . ")";
        }
        if ($category !== null) {
            $sql .= " AND category_id IN (" . implode(",", $category) . ")";
        }
        if ($year !== null) {
            $sql .= " AND model_year IN (" . implode(",", $year) . ")";
        }
        if ($price !== null) {
            $sql .= " AND list_price IN (" . implode(",", $price) . ")";
        }

        $sth = $db->prepare($sql);
        $sth->execute($params);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        return $sth->fetchAll();
    }

    public static function getProductFromId($id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM products WHERE product_id = :id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        $sth->execute();
        return $sth->fetch();
    }

    public static function getProductFromBrand($brand)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM products INNER JOIN brands ON products.brand_id = brands.brand_id WHERE products.brand_id = :brand";
        $sth = $db->prepare($sql);
        $sth->bindValue(":brand", $brand, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getProductFromCategory($category)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM products INNER JOIN categories ON products.category_id = categories.category_id WHERE products.category_id = :category";
        $sth = $db->prepare($sql);
        $sth->bindValue(":category", $category, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getProductFromYear($year)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM products WHERE model_year = :year";
        $sth = $db->prepare($sql);
        $sth->bindValue(":year", $year, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getProductFromPrice($price)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM products WHERE list_price = :price";
        $sth = $db->prepare($sql);
        $sth->bindValue(":price", $price, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Products");
        $sth->execute();
        return $sth->fetchAll();
    }
}
