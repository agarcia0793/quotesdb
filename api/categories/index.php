<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    require_once('../../config/Database.php');
    require_once('../../models/Category.php');
    require_once('../../functions/isValid.php');

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $id = null;

    if ($method === 'GET') {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    }


    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id) && $method !== 'GET') { $id = $data->id; }
    

    if ($method !== 'POST' && $id) {
        $categoryExists = isValid($id, $category);
        if (!$categoryExists) { 
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
            exit();
        }
    }

    if ($method === 'GET') { require_once('read.php'); };
    if ($method === 'POST') { require_once('create.php'); };
    if ($method === 'PUT') { require_once('update.php'); };
    if ($method === 'DELETE') { require_once('delete.php'); };