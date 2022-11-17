<?php

require_once('.config.php');

class Mcliente{

        private $table = 'cliente';


    public function read() {
      $db = new Dbase();
        try {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table");
            $stm->execute();

            $res = array();

            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $key => $dato) {

                $statement = $db->getConnection()->prepare("SELECT * from producto WHERE idpro = ?");
                $statement->execute([
                    $dato->idC
                ]);

                $fk = $statement->fetch(PDO::FETCH_OBJ);

                array_push($res,array(
                    'id' =>  $dato->id ,
                    'nombre' =>  $dato->nombre,
                    'telefono' =>  $dato->telefono,         
                    'correo' =>  $dato->correo, 
                    "data_fk"=> array(
                      'idpro' =>  $fk->idpro ,
                      'artista' =>  $fk->artista,
                      'album' =>  $fk->album ,
                      'idC' =>  $fk->idC,
                      'fecha de entrada'=> $fk->fechadeentrada,
                      'fecha de salida'=> $fk->fechadesalida,
                      'cantidad'=> $fk->cantidad,
                      'precio'=> $fk->precio,
                      'correo'=> $fk->correo

                    ))
                  );               
            }

            return $res;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function create()
    {

        $db = new Dbase();

        try {

            $stm = $db->getConnection()->prepare("INSERT INTO $this->table
            (nombre,telefono,correo) VALUES (?,?,?)");

            $stm->execute([
                $_POST['nombre'],
                $_POST['telefono'],
                $_POST['correo'],
               
            ]);


            //busca el los datos del fk 
            $sql1 = $db->getConnection()->prepare("SELECT * FROM producto where idpro = ?");
            $sql1->execute([
                $_POST['idC']
            ]);

            $fk = $sql1->fetch(PDO::FETCH_OBJ);

            return $fk;
        } catch (PDOException $e) {
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                'error' => [
                    'codigo' => $e->getCode(),
                    'mensaje' => $e->getMessage()
                ]
            ]);
        }
    }

    //Eliminacion de datos
    public function delete()
    {

        $db = new Dbase();

        try {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([$_POST['id']]);
            $result = $sql->rowCount();

            if ($result <= 0) {
                $res = array("ID " . $_POST['id'] => "no exite registro");

                return $res;
            } else {

                $dato = $sql->fetch(PDO::FETCH_OBJ);

                //busca el los datos del fk 
                $sql1 = $db->getConnection()->prepare("SELECT * FROM producto where idpro= ?");
                $sql1->execute([$dato->idC]);

                $fk = $sql1->fetch(PDO::FETCH_OBJ);


                $id = $_POST['id'];
                $statement = $db->getConnection()->prepare("DELETE FROM $this->table where id= ?");
                $statement->execute([
                    $id
                ]);
                header("HTTP/1.1 200 OK");

                $res = array(
                    'mensaje' => 'Registro eliminado satisfactoriamente',
                    'id' =>  $dato->id ,
                    'nombre' =>  $dato->nombre,
                    'telefono' =>  $dato->telefono,         
                    'correo' =>  $dato->correo, 
                    "data_fk"=> array(
                      'idpro' =>  $fk->idpro ,
                      'artista' =>  $fk->artista,
                      'album' =>  $fk->album ,
                      'idC' =>  $fk->idC,
                      'fecha de entrada'=> $fk->fechadeentrada,
                      'fecha de salida'=> $fk->fechadesalida,
                      'cantidad'=> $fk->cantidad,
                      'precio'=> $fk->precio,
                      'correo'=> $fk->correo
                    )
                );

                return $res;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Actualizacion de datos
    public function update()
    {

        $db = new Dbase();


        try {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([
                $_POST['id']
            ]);

            $result = $sql->rowCount();

            if ($result <= 0) {
                $res = array("ID " . $_POST['id'] => "no exite registro");

                return $res;
            } else {

                $dato = $sql->fetch(PDO::FETCH_OBJ);

                $sql = "UPDATE $this->table SET nombre = ?,telefono = ?, correo = ?, WHERE id= ? ";

                $statement = $db->getConnection()->prepare($sql);
                $statement->execute([
                    $_POST['nombre'],
                    $_POST['telefono'],
                    $_POST['correo'],
                    $_POST['id']
                ]);


                //busca el los datos del fk 
                $sql1 = $db->getConnection()->prepare("SELECT * FROM producto where idpro= ?");
                $sql1->execute([$_POST['idC']]);

                $fk = $sql1->fetch(PDO::FETCH_OBJ);

                $res = array(
                    'mensaje' => 'Registro Actualizado satisfactoriamente',
                    'id' =>  $dato->id ,
                    'nombre' =>  $dato->nombre,
                    'telefono' =>  $dato->telefono,         
                    'correo' =>  $dato->correo, 
                    "data_fk"=> array(
                      'idpro' =>  $fk->idpro ,
                      'artista' =>  $fk->artista,
                      'album' =>  $fk->album ,
                      'idC' =>  $fk->idC,
                      'fecha de entrada'=> $fk->fechadeentrada,
                      'fecha de salida'=> $fk->fechadesalida,
                      'cantidad'=> $fk->cantidad,
                      'precio'=> $fk->precio,
                      'correo'=> $fk->correo
                    )

                );

                return $res;
            }
        } catch (PDOException $e) {
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                'error' => [
                    'codigo' => $e->getCode(),
                    'mensaje' => $e->getMessage()
                ]
            ]);
        }
    }

    //Obtiene un registro por Id
    public function clienteId()
    {

        $db = new Dbase();
        try {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where id= ?");
            $sql->execute([$_GET['id']]);
            $result = $sql->rowCount();

            if ($result <= 0) {
                $res = array("ID " . $_GET['id'] => "no exite este registro");

                return $res;
            } else {

                //Mostrar lista de post
                $sql = $db->getConnection()->prepare("SELECT * FROM $this->table WHERE ID = ?");
                $sql->execute([$_GET['id']]);

                $dato = $sql->fetch(PDO::FETCH_OBJ);

                //busca el los datos del fk 
                $sql1 = $db->getConnection()->prepare("SELECT * FROM producto where idpro= ?");
                $sql1->execute([$dato->idC]);

                $fk = $sql1->fetch(PDO::FETCH_OBJ);

                $res =  array(
                  'id' =>  $dato->id ,
                  'nombre' =>  $dato->nombre,
                  'telefono' =>  $dato->telefono,         
                  'correo' =>  $dato->correo, 
                  "data_fk"=> array(
                    'idpro' =>  $fk->idpro ,
                    'artista' =>  $fk->artista,
                    'album' =>  $fk->album ,
                    'idC' =>  $fk->idC,
                    'fecha de entrada'=> $fk->fechadeentrada,
                    'fecha de salida'=> $fk->fechadesalida,
                    'cantidad'=> $fk->cantidad,
                    'precio'=> $fk->precio,
                    'correo'=> $fk->correo
                  )
                );

                header("HTTP/1.1 200 OK");
                echo json_encode($res);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}