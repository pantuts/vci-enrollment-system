<?php

require_once '../config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $course = htmlentities($_POST['course']);
    $code = strtoupper(htmlentities($_POST['code']));
    $curcode = htmlentities($_POST['curcode']);
    $desc = ucwords(htmlentities($_POST['desc']));
    $units = htmlentities($_POST['units']);
    $time = strtoupper(htmlentities($_POST['time']));
    $sem = htmlentities($_POST['sem']);
    $yr = htmlentities($_POST['year']);
    $room = strtoupper(htmlentities($_POST['room']));

    if (!isset($_POST['new'])) {
        $sql = 'update ' . $course . ' set code=:c, description=:d, units=:u, time=:t, room=:r, semester=:s, studyear=:sy where code=:cc';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute(array(
                ':c' => $code,
                ':d' => $desc,
                ':u' => $units,
                ':t' => $time,
                ':r' => $room,
                ':s' => $sem,
                ':sy' => $yr,
                ':cc' => $curcode
            ));
            $msg['success'] = 'Sucessfull update';
            echo json_encode($msg);
            header('HTTP/ 200 Ok');
        } catch (PDOException $e) {
            $msg['error'] = $e->getMessage();
            echo json_encode($msg);
            header('HTTP/ 400 Problem on sql');
        }
    } else {
        $new = htmlentities($_POST['new']);
        if ($new == 'new') {
            $sql = 'select id from ' . $course . ' where code=:c';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':c' => $code));
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($row !== FALSE) {
                $msg['error'] = 'ERROR: Existing subject';
                echo json_encode($msg);
                header('HTTP/ 400 Existing Subject');
            } else {
                $sql = 'insert into ' . $course . ' (code, description, units, time, room, semester, studyear) values (:c, :d, :u, :t, :r, :s, :sy)';
                $stmt = $pdo->prepare($sql);
                try {
                    $stmt->execute(array(
                        ':c' => $code,
                        ':d' => $desc,
                        ':u' => $units,
                        ':t' => $time,
                        ':r' => $room,
                        ':s' => $sem,
                        ':sy' => $yr
                    ));
                    $msg['success'] = 'Sucessfull update';
                    echo json_encode($msg);
                    header('HTTP/ 200 Ok');
                } catch (PDOException $e) {
                    $msg['error'] = $e->getMessage();
                    echo json_encode($msg);
                    header('HTTP/ 400 Problem on sql');
                }
            }
        }
    }

    $stmt->closeCursor();
    $pdo = null;
}

?>