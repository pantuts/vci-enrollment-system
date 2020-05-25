<?php

ob_start();

if ( $_SERVER['REQUEST_METHOD'] === 'POST'
    && ( isset($_POST['subjects']) && !empty($_POST['subjects']) )) {

    require_once '../config.php';
    $subjects = rtrim(htmlentities($_POST['subjects']), '$');
    $studnum = htmlentities($_POST['studnum']);

    // update table registers
    $sql = 'update registers set evaluated=1 where studnum=:sn';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(':sn' => $studnum));
    } catch (PDOException $e) {
        // send back error to main.js
        // only in console.log
        $msg['error'] = $e->getMessage();
        echo json_encode($msg);
        header('HTTP/ 400 Error in Sql');
        ob_end_flush();
    }

    $sql = 'insert into evaluated (studnum, subjects) values (:sn, :subjs)';
    $stmt = $pdo->prepare($sql);
     try {
        $stmt->execute(array(':sn' => $studnum, ':subjs' => $subjects));
    } catch (PDOException $e) {
        // send back error to main.js
        // only in console.log
        $msg['error'] = $e->getMessage();
        echo json_encode($msg);
        header('HTTP/ 400 Error in Sql');
        ob_end_flush();
    }

} else {
    header('Location: ./index.php');
    ob_end_flush();
}

?>