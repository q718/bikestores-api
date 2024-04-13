<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once("../model/PDOConnexion.php");
require_once("../model/Brands.class.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case "getBrand":
                    if (isset($_GET['id'])) {
                        $brand_id = $_GET['id'];
                        $brand = Brands::getBrandFromId($brand_id);
                        echo json_encode($brand, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                default:
                    echo json_encode(array('error' => 'Invalid action'));
                    break;
            }
        } else {
            $brands = Brands::getAll();
            echo json_encode($brands, JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(array('error' => 'Invalid request method'));
        break;
}
