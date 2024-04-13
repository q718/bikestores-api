<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once("../model/PDOConnexion.php");
require_once("../model/Stores.class.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case "getStore":
                    if (isset($_GET['id'])) {
                        $store_id = $_GET['id'];
                        $store = Stores::getStoreFromId($store_id);
                        echo json_encode($store, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                default:
                    echo json_encode(array('error' => 'Invalid action'));
                    break;
            }
        } else {
            $stores = Stores::getAll();
            echo json_encode($stores, JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(array('error' => 'Invalid request method'));
        break;
}
