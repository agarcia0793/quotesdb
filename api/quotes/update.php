<?php 
    
    if (
        !empty($data->quote) && 
        !empty($author_id) && 
        !empty($category_id) && 
        !empty($id)
        ) {

            $quote->quote = $data->quote;
            $quote->author_id = $author_id;
            $quote->category_id = $category_id;
            $quote->id = $id;

            try {
                $result = $quote->update();
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