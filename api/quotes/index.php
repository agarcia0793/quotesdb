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
    require_once('../../models/Quote.php');
    require_once('../../models/Author.php');
    require_once('../../models/Category.php');
    require_once('../../functions/isValid.php');

    $database = new Database();
    $db = $database->connect();
    
    $quote = new Quote($db);
    $author = new Author($db);
    $category = new Category($db);

    $id = null;
    $author_id = null;
    $category_id = null;
    $random = null;


    if ($method === 'GET') {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $author_id = filter_input(INPUT_GET, 'author_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
        $random = filter_input(INPUT_GET, 'random', FILTER_VALIDATE_BOOLEAN);
    }


    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id) && $method !== 'GET')  { $id = $data->id; };
    if (!empty($data->author_id) && $method !== 'GET')  { $author_id = $data->author_id; };
    if (!empty($data->category_id) && $method !== 'GET')  { $category_id = $data->category_id; };
        

    if ($method !== 'DELETE' && $author_id) {
        
        $authorExists = isValid($author_id, $author);
        if (!$authorExists) { 
            echo json_encode(
                array('message' => 'author_id Not Found')
            );
            exit();
        }
    }


    if ($method !== 'DELETE' && $category_id) {
    
        $categoryExists = isValid($category_id, $category);
        if (!$categoryExists) { 
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
            exit();
        }
    }


    if ($method === 'DELETE' || $method === 'PUT') {
        $idExists = isValid($id, $quote);
        if (!$idExists) { 
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
            exit();
        }
    }

    if ($method === 'GET') { require_once('read.php'); };
    if ($method === 'POST') { require_once('create.php'); };
    if ($method === 'PUT') { require_once('update.php'); };
    if ($method === 'DELETE') { require_once('delete.php'); };