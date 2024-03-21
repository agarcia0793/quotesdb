<?php 
    
    if (!empty($data->author) && !empty($id)) {

        $author->author = $data->author;
        $author->id = $id;
        
        try {
            $result = $author->update();
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