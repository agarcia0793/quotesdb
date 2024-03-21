<?php 

    $quote->id = $id;

    try {
        $quote->read_single();

        if (!empty($quote->quote)) {
            $quote_arr = array(
                'id' => $quote->id, 
                'quote' => $quote->quote, 
                'author' => $quote->author, 
                'category' => $quote->category
            );
        } else {
            $quote_arr = array(
                'message' => 'No Quotes Found'
            );
        }
        
        echo json_encode($quote_arr);
        
    } catch (Exception $e) {
        echo json_encode(
            array('message' => $e->getMessage())
        );
    }
    exit();