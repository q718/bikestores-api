<?php
require_once("PDOConnexion.php");

class Categories implements JsonSerializable
{
    private $category_id;
    private $category_name;

    public function __construct(array $t = array())
    {
        foreach ($t as $k => $v) {
            $this->$k = $v;
        }
    }

    public function __get($category_id)
    {
        return $this->$category_id;
    }

    public function __set($category_id, $v)
    {
        $this->$category_id = $v;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function getAll()
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM categories";
        $sth = $db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Categories");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getCategoryFromId($id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM categories WHERE category_id = :id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Categories");
        $sth->execute();
        return $sth->fetch();
    }
}
