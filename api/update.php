<?php

require '../config.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put') {

    parse_str(file_get_contents('php://input'), $input);

    $id = $input['id'] ?? null;
    $name = $input['name'] ?? null;
    $status = $input['status'] ?? null;

    $id = filter_var($id);
    $name = filter_var($name);
    $status = filter_var($status);

    if($id && $name && $status) {

        $sql = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $pdo->prepare("UPDATE tasks SET id = :id, name = :name, status = :status WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':name', $name);
            $sql->bindValue(':status', $status);
            $sql->execute();

            $array['result'] = [
                'id' => $id,
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