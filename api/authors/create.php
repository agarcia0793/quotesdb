<?php 
    
    if (!empty($data->author)) {

        $author->author = $data->author;
        
        try {
            $result = $author->create();
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(
                array('message' => $e->getMessage())
            );
        }
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    exit();