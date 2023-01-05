<?php

require '../config.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get') {

    $id = filter_input(INPUT_GET, 'id');

    if($id) {
        $sql = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $array['result'] = [
                'id' => $data['id'],
                'author' => $data['author'],
                'name' => $data['name'],
                'status' => $data['status']
            ];

        }else {
            $array['error'] = 'ID não encontrado';
        }
    }else {
        $array['error'] = 'ID não enviado';
    }


}else {
    $array['error'] = 'Método inválido(apenas GET)';
}

require '../return.php';