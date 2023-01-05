<?php

require '../config.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put') {

    parse_str(file_get_contents('php://input'), $input);

    $id = $input['id'] ?? null;
    $author = $input['author'] ?? null;
    $name = $input['name'] ?? null;
    $status = $input['status'] ?? null;

    $id = filter_var($id);
    $author = filter_var($author);
    $name = filter_var($name);
    $status = filter_var($status);

    if($id && $author && $name && $status) {

        $sql = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $pdo->prepare("UPDATE tasks SET id = :id, author = :author, name = :name, status = :status WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':author', $author);
            $sql->bindValue(':name', $name);
            $sql->bindValue(':status', $status);
            $sql->execute();

            $array['result'] = [
                'id' => $id,
                'author' => $author,
                'name' => $name,
                'status' => $status
            ];

        }else {
            $array['error'] = 'ID não encontrado';
        }

    }else {
        $array['error'] = 'Campos obrigatórios';
    }


}else {
    $array['error'] = 'Método inválido(apenas PUT)';
}


require '../return.php';