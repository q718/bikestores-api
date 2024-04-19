<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once("../model/PDOConnexion.php");
require_once("../model/Products.class.php");
require_once("../model/Brands.class.php");
require_once("../model/Categories.class.php");

$request_method = $_SERVER["REQUEST_METHOD"];

// Vérification de la clé d'accès pour les opérations autres que GET
if ($request_method !== "GET") {
    $api_key = isset($_GET['api_key']) ? $_GET['api_key'] : null;

    if ($api_key !== "e8f1997c763") {
        echo json_encode(array('error' => 'Invalid API key'));
        http_response_code(403);
        exit();
    }
}

switch ($request_method) {
    case "GET":
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case "getProduct":
                    if (isset($_GET['id'])) {
                        $product_id = $_GET['id'];
                        $product = Products::getProductFromId($product_id);
                        echo json_encode($product, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getCategoryProducts":
                    if (isset($_GET['id'])) {
                        $category = explode(',', $_GET['id']); // Séparez les ID de catégorie s'ils sont multiples
                        $category_products = array();

                        // Boucle à travers chaque ID de catégorie
                        foreach ($category as $category_id) {
                            $category = Products::getProductFromCategory($category_id);
                            $category_products = array_merge($category_products, $category); // Fusionnez les résultats dans un tableau unique
                        }

                        echo json_encode($category_products, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getBrandProducts":
                    if (isset($_GET['id'])) {
                        $brand = explode(',', $_GET['id']); // Séparez les ID de marque s'ils sont multiples
                        $brand_products = array();

                        // Boucle à travers chaque ID de marque
                        foreach ($brand as $brand_id) {
                            $brand = Products::getProductFromBrand($brand_id);
                            $brand_products = array_merge($brand_products, $brand); // Fusionnez les résultats dans un tableau unique
                        }

                        echo json_encode($brand_products, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getYearProducts":
                    if (isset($_GET['id'])) {
                        $year_id = $_GET['id'];
                        $year = Products::getProductFromYear($year_id);
                        echo json_encode($year, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getPriceProducts":
                    if (isset($_GET['id'])) {
                        $price_id = $_GET['id'];
                        $price = Products::getProductFromPrice($price_id);
                        echo json_encode($price, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "filter":
                    $brand = isset($_GET['brand']) ? explode(',', $_GET['brand']) : null;
                    $category = isset($_GET['category']) ? explode(',', $_GET['category']) : null;
                    $year = isset($_GET['year']) ? explode(',', $_GET['year']) : null;
                    $price = isset($_GET['price']) ? explode(',', $_GET['price']) : null;

                    $filtered_products = Products::getAll($brand, $category, $year, $price);

                    echo json_encode($filtered_products, JSON_UNESCAPED_UNICODE);
                    break;

                default:
                    echo json_encode(array('error' => 'Invalid action'));
                    break;
            }
        } else {
            $products = Products::getAll();
            echo json_encode($products, JSON_UNESCAPED_UNICODE);
        }
        break;

    case "POST":
        echo json_encode(array('authorized' => 'POST'));
        break;

    case "PUT":
        echo json_encode(array('authorized' => 'PUT'));
        break;

    case "DELETE":
        echo json_encode(array('authorized' => 'DELETE'));
        break;

    default:
        echo json_encode(array('error' => 'Invalid request method'));
        break;
}
