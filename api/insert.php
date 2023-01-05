<?php

require '../config.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post') {
    $author = filter_input(INPUT_POST, 'author');
    $name = filter_input(INPUT_POST, 'name');

    if($author && $name) {

        $sql = $pdo->prepare("INSERT INTO tasks (author, name) VALUES(:author, :name)");
        $sql->bindValue(':author', $author);
        $sql->bindValue(':name', $name);
        $sql->execute();

        $id = $pdo->lastInsertId();

        $array['result'] = [
            'id' => $id,
            'author' => $author,
            'name' => $name
        ];

    }else {
        $array['error'] = 'Campos obrigatórios';
    }

    
}else {
    $array['error'] = 'Método inválido(apenas POST)';
}

require '../return.php';