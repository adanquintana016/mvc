<?php

class Cproducto{

public function read(){
    
    require_once("Models/productomod.php");

    $model = new Mproducto();

    header('Content-type:application/json;charset=utf-8');
    return json_encode($model->read());
 
}

public function create(){

    $json = json_decode(file_get_contents("php://input"), true);
    
    $json['artista'] = $_POST['artista'];
    $json['album']= $_POST['album'];
    $json['idC'] = $_POST['idC'];
    $json['fecha de entrada'] = $_POST['fecha de entrada'];
    $json['fecha de salida']= $_POST['fecha de salida'];
    $json['cantidad'] = $_POST['cantidad'];
    $json['precio'] = $_POST['precio'];
    $json['correo'] = $_POST['correo'];

    require_once("Models/productomod.php");

    $model = new Mproducto();

    $json['id'] = $model->create();

    header('Content-type:application/json;charset=utf-8');
    return json_encode($json);

}

public function delete(){
    
    require_once("Models/productomod.php");

    $model = new Mproducto();
    
    header('Content-type:application/json;charset=utf-8');
    return json_encode([
        $model->delete()
    ]);
 
}

public function update(){
    require_once("Models/productomod.php");

    $model = new Mproducto();
    
    
    header('Content-type:application/json;charset=utf-8');
    return json_encode([
        $model->update()
    ]);
 
}

public function peliculaId(){

    require_once("Models/productomod.php");

    $model = new Mproducto();

    header('Content-type:application/json;charset=utf-8');
    return json_encode($model->productoId());
 
}


}