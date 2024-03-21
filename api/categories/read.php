<?php 


if ($id) { require_once('read_single.php'); }


try {
    $result = $category->read();

    if ($result && $result->rowCount() > 0) {

        $num = $result->rowCount();

        $categories_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id, 
                'category' => $category
            );

            array_push($categories_arr, $category_item);
        }

        echo json_encode($categories_arr);
        
    } else {
        echo json_encode(
            array('message' => 'No Categories Found')
        );
    }
    
} catch (Exception $e) {
    echo json_encode(
        array('message' => $e->getMessage())
    );
}
exit();