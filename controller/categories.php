<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once("../model/PDOConnexion.php");
require_once("../model/Categories.class.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case "getCategory":
                    if (isset($_GET['id'])) {
                        $category_id = $_GET['id'];
                        $category = Categories::getCategoryFromId($category_id);
                        echo json_encode($category, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                default:
                    echo json_encode(array('error' => 'Invalid action'));
                    break;
            }
        } else {
            $categories = Categories::getAll();
            echo json_encode($categories, JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(array('error' => 'Invalid request method'));
        break;
}
