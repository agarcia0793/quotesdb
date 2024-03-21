<?php 
    
    if (!empty($data->category)) {

        $category->category = $data->category;
    
        try {
            $result = $category->create();
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