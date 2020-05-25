<?php

ob_start();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['studnum'])) {
    
    require_once '../config.php';

    $studnum = htmlentities($_POST['studnum']);

    $sql = 'delete from registers, profiles, student using registers';
    $sql .= ' inner join profiles inner join student';
    $sql .= ' where registers.studnum=:sn';
    $sql .= ' and profiles.studnum=registers.studnum and student.studnum=registers.studnum';
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

    // delete from evaluated
    // first select then if not false delete
    $sql = 'select studnum from evaluated where studnum=:sn';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(':sn' => $studnum));
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($row !== FALSE) {
            $sql = 'delete from evaluated where studnum=:sn';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':sn' => $studnum));
        }
    } catch (PDOException $e) {
        // send back error to main.js
        // only in console.log
        $msg['error'] = $e->getMessage();
        echo json_encode($msg);
        header('HTTP/ 400 Problem deleting from evaluated');
        ob_end_flush();
    }

    $stmt->closeCursor();
    $pdo = null;

} else {
    header('Location: ./index.php');
    ob_end_flush();
}

?>

?>