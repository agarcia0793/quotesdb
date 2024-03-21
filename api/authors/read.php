<?php 
    

if ($id) { require_once('read_single.php'); }


try {
    $result = $author->read();

    if ($result && $result->rowCount() > 0) {

        $num = $result->rowCount();

        $authors_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id, 
                'author' => $author
            );

            array_push($authors_arr, $author_item);
        }

        echo json_encode($authors_arr);
        
    } else {
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }
    
} catch (Exception $e) {
    echo json_encode(
        array('message' => $e->getMessage())
    );
}
exit();