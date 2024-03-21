<?php 

    $category->id = $id;

    try {
        $category->read_single();

        if (!empty($category->category)) {
            $category_arr = array(
                'id' => $category->id, 
                'category' => $category->category 
            );
        } else {
            $category_arr = array(
                'message' => 'No Categories Found'
            );
        }
        
        echo json_encode($category_arr);
        
    } catch (Exception $e) {
        echo json_encode(
            array('message' => $e->getMessage())
        );
    }
    exit();