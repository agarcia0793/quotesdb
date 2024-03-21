<?php 


if ($id) { require_once('read_single.php'); }

if ($author_id) { $quote->author_id = $author_id; };
if ($category_id) { $quote->category_id = $category_id; };

try {
    $result = $quote->read();


    if ($result && $result->rowCount() > 0) {

        $num = $result->rowCount(); 
 
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id, 
                'quote' => $quote, 
                'author' => $author, 
                'category' => $category
            );
    
            array_push($quotes_arr, $quote_item);
        }

  
        if ($num > 1 && $random) {
            $randNum = rand(0,$num - 1);
            echo json_encode($quotes_arr[$randNum]);
        } else {
            echo json_encode($quotes_arr);
        }

    } else {
 
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
} catch (Exception $e) {
    echo json_encode(
        array('message' => $e->getMessage())
    );
}
exit();