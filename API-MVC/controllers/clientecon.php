<?php

class Ccliente{

  public function read(){
      
      require_once("Models/clientemod.php");

      $model = new Mcliente();          

      header('Content-type:application/json;charset=utf-8');
      return json_encode([
          $model->read()
      ]);
   
  }
  #crea un nuevo cliente
  public function create(){

      $json["nombre"] =  $_POST['nombre'];
      $json["telefono"] = $_POST['telefono'];
      $json["correo"] =  $_POST['correo']; 

      require_once("Models/clientemod.php");

      $model = new Mcliente();  
      
      $json["peliculas"] = $model->create();

      header('Content-type:application/json;charset=utf-8');
      return json_encode([
          $json
      ]);

  }

  public function delete(){
      
    require_once("Models/clientemod.php");

      $model = new Mcliente();  
      
      header('Content-type:application/json;charset=utf-8');
      return json_encode([
          $model->delete()
      ]);
   
  }

  public function update(){
    
    require_once("Models/clientemod.php");

      $model = new Mcliente();  
      
      header('Content-type:application/json;charset=utf-8');
      return json_encode([
          $model->update()
      ]);
   
  }
  
  public function actoresId(){
    require_once("Models/clientemod.php");

      $model = new Mcliente();  
      
      header('Content-type:application/json;charset=utf-8');
      return json_encode($model->clienteId());
   
  }
 
}
