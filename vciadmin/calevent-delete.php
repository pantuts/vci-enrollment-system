<?php

require_once '../config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) ) {
    $id = htmlentities($_POST['id']);
    $sql = 'delete from calevents where id=:id';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(':id' => $id));
        $msg['success'] = 'Sucessfull delete';
        echo json_encode($msg);
        header('HTTP/ 200 Ok');
    } catch (PDOException $e) {
        $msg['error'] = $e->getMessage();
        echo json_encode($msg);
        header('HTTP/ 400 Problem on sql');
    }
    $stmt->closeCursor();
    $pdo = null;
}

?>