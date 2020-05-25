<?php

require_once '../config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $code = htmlentities($_POST['code']);
    $course = htmlentities($_POST['course']);
    $sql = 'delete from ' . $course . ' where code=:c';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(':c' => $code));
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