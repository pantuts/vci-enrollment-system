<?php

require_once '../config.php';
ob_start();

$year = htmlentities($_POST['year']);
$month = htmlentities($_POST['month']);
$day = htmlentities($_POST['day']);
$desc = ucwords(htmlentities($_POST['description']));

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['edit'] == 'new') {

    $sql = 'select id from calevents where day=:d and month=:m and year=:y and event=:ds';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(
            ':d' => $day,
            ':m' => $month,
            ':y' => $year,
            ':ds' => $desc
        ));
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        // if the same event exists, do nothing
        if ($row !== FALSE) {
            $stmt->closeCursor();
            $pdo = null;
            $msg['message'] = 'Duplicate entry!';
            echo json_encode($msg);
            header('HTTP/ 400 Duplicate');
            ob_end_flush();
            exit;
        } else {
            $sql1 = 'insert into calevents (month, day, year, event) values (:m, :d, :y, :ds)';
            $stmt1 = $pdo->prepare($sql1);
            try {
                $stmt1->execute(array(
                    ':d' => $day,
                    ':m' => $month,
                    ':y' => $year,
                    ':ds' => $desc
                ));
                $msg['newid'] = $pdo->lastInsertID();
                echo json_encode($msg);
                $stmt1->closeCursor();
                $pdo = null;
            } catch (PDOException $e) {
                $msg['message'] = $e->getMessage();
                echo json_encode($msg);
                header('HTTP/ 400');
                ob_end_flush();
            }
        }
        $stmt->closeCursor();
        $pdo = null;
    } catch (PDOException $e) {
        $msg['message'] = $e->getMessage();
        echo json_encode($msg);
        header('HTTP/ 400');
        ob_end_flush();
    }


} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['edit'] == 'old') {

    $id = htmlentities($_POST['id']);
    $sql = 'update calevents set month=:m, day=:d, year=:y, event=:ds where id=:id';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(
            ':d' => $day,
            ':m' => $month,
            ':y' => $year,
            ':ds' => $desc,
            ':id' => $id
        ));
    } catch (PDOException $e) {
        $msg['message'] = $e->getMessage();
        json_encode($msg);
        header('HTTP/ 400');
        ob_end_flush();
    }
    $stmt->closeCursor();
    $pdo = null;

} else {
    exit();
}

?>