<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

require_once("../model/PDOConnexion.php");
require_once("../model/Employees.class.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        if (isset($_GET['action'])) {
            $action = $_GET['action'];

            switch ($action) {
                case "getEmployee":
                    if (isset($_GET['id'])) {
                        $employee_id = $_GET['id'];
                        $employee = Employees::getEmployeeFromId($employee_id);
                        echo json_encode($employee, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                case "getStoreEmployees":
                    if (isset($_GET['id'])) {
                        $employee_id = $_GET['id'];
                        $employee = Employees::getEmployeeFromStore($employee_id);
                        echo json_encode($employee, JSON_UNESCAPED_UNICODE);
                    } else {
                        echo json_encode(array('error' => 'Missing ID parameter'));
                    }
                    break;

                default:
                    echo json_encode(array('error' => 'Invalid action'));
                    break;
            }
        } else {
            $employees = Employees::getAll();
            echo json_encode($employees, JSON_UNESCAPED_UNICODE);
        }
        break;

    default:
        echo json_encode(array('error' => 'Invalid request method'));
        break;
}
