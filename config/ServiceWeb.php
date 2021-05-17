<?php

require('ConnectionDB.php');

$email = strip_tags($_POST["email"], ENT_QUOTES);

if ($email != NULL || strlen($email) != 0) {
    try {
        $query = ConnectionDB::getConnection()->prepare('SELECT * FROM EmailClient WHERE email = :email');
        $query->execute(['email' => $email]);
        if ($query->rowCount() == 0) {
            $query = ConnectionDB::getConnection()->prepare('INSERT INTO EmailClient(email) VALUES(:email)');
            if ($query->execute(['email' => $email])) {
                $dataArray = ['status' => 'ok', 'data' => 'Registro correcto'];
                echo json_encode($dataArray);
            } else {
                $dataArray = ['status' => 'error', 'data' => 'Intentalo nuevamente.'];
                echo json_encode($dataArray);
            }
        } else {
            $dataArray = ['status' => 'error', 'data' => 'Intentalo nuevamente.'];
            echo json_encode($dataArray);
        }
    } catch (PDO $ex) {
        $dataArray = ['status' => 'error', 'data' => 'Intentalo nuevamente.'];
        echo json_encode($dataArray);
    }
} else {
    $dataArray = ['status' => 'empty', 'data' => 'Email vacío'];
    echo json_encode($dataArray);
}
