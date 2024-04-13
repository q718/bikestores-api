<?php
require_once("PDOConnexion.php");

class Employees implements JsonSerializable
{
    private $employee_id;
    private $store_id;
    private $employee_name;
    private $employee_email;
    private $employee_password;
    private $employee_role;

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
        $sql = "SELECT * FROM employees";
        $sth = $db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Employees");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function getEmployeeFromId($id)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM employees WHERE employee_id = :id";
        $sth = $db->prepare($sql);
        $sth->bindValue(":id", $id, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Employees");
        $sth->execute();
        return $sth->fetch();
    }

    public static function getEmployeeFromStore($store)
    {
        $db = PDOConnexion::getInstance();
        $sql = "SELECT * FROM employees INNER JOIN stores ON employees.store_id = stores.store_id WHERE employees.store_id = :store";
        $sth = $db->prepare($sql);
        $sth->bindValue(":store", $store, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Employees");
        $sth->execute();
        return $sth->fetchAll();
    }
}
