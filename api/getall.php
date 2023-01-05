<?php

require '../config.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get') {

    $sql = $pdo->query("SELECT * FROM tasks");
    
    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $item) {
            $array['result'][] = [
                'name' => $item['name'],
                'status' => $item['status']
            ];
        }
    }



}else {
    $array['error'] = 'Método inválido(apenas GET)';
}


require '../return.php';