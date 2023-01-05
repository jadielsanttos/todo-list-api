<?php

require '../config.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post') {

    $name = filter_input(INPUT_POST, 'name');

    if($name) {

        $sql = $pdo->prepare("INSERT INTO tasks (name) VALUES(:name)");
        $sql->bindValue(':name', $name);
        $sql->execute();

        $id = $pdo->lastInsertId();

        $array['result'] = [
            'id' => $id,
            'name' => $name,
        ];

    }else {
        $array['error'] = 'Campos obrigatórios';
    }



}else {
    $array['error'] = 'Método inválido(apenas POST)';
}


require '../return.php';