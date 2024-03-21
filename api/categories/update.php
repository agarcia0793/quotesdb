<?php 
    
    if (!empty($data->category) && !empty($id)) {

        $category->category = $data->category;
        $category->id = $id;
        
        try {
            $result = $category->update();
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(
                array('message' => $e->getMessage())
            );
        }
    }   else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    exit();