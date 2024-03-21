<?php 

function isValid($id, $model) {
    $model->id = $id; 
    $modelResult = $model->read_single();
    return $modelResult;
}