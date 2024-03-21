<?php 
    
    if (!empty($id)) {

        $author->id = $id;
        
        try {
            $result = $author->delete();
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