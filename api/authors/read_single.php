<?php 
    
    $author->id = $id;

    try {
        $author->read_single();

        if (!empty($author->author)) {
            $author_arr = array(
                'id' => $author->id, 
                'author' => $author->author 
            );
        } else {
            $author_arr = array(
                'message' => 'No Authors Found'
            );
        }
        
        echo json_encode($author_arr);
        
    } catch (Exception $e) {
        echo json_encode(
            array('message' => $e->getMessage())
        );
    }
    exit();