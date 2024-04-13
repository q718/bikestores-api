<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once("../model/PDOConnexion.php");
require_once("../model/Stocks.class.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case "getStock":
                    if (isset($_GET['id'])) {
                        $stock_id = $_GET['id'];
                        $stock = Stocks::getStockFromId($stock_id);
                        echo json_encode($stock, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getStoreStocks":
                    if (isset($_GET['id'])) {
                        $stock_id = $_GET['id'];
                        $stock = Stocks::getStockFromStore($stock_id);
                        echo json_encode($stock, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getProductStocks":
                    if (isset($_GET['id'])) {
                        $stock_id = $_GET['id'];
                        $stock = Stocks::getStockFromProduct($stock_id);
                        echo json_encode($stock, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                default:
                    echo json_encode(array('error' => 'Invalid action'));
                    break;
            }
        } else {
            $stocks = Stocks::getAll();
            echo json_encode($stocks, JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(array('error' => 'Invalid request method'));
        break;
}
