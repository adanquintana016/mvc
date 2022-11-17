<?php


require_once('.config.php');

class Mproducto{

    private $table = 'producto';

    public function read(){

        $db = new Dbase();

        try
        {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table");
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            return $result;
       
           
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    
    }

    public function create(){

        $db = new Dbase();

        try{

            $stm= $db->getConnection()->prepare("INSERT INTO $this->table (artista,album,idC,fecha de entrada,fecha de salida,cantidad,precio,correo) VALUES (?,?,?,?,?;?,?,?)");
            
            $stm->execute([
                $_POST['artista'],
                $_POST['album'],
                $_POST['idC'],
                $_POST['fecha de entrada'],
                $_POST['fecha de salida'],
                $_POST['cantidad'],
                $_POST['precio'],
                $_POST['correo'],
            ]);

        }catch(PDOException $e){
        echo $e->getMessage();
        }
    }

        //Elimina un registro por Id
    public function delete(){

        $db = new Dbase();

        try
        {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([$_POST['id']]);
            $result = $sql->rowCount();

            if ($result<=0) {
                $res = array("ID ". $_POST['id'] => "no exite registro");

                return $res;

            } else {
            
                $dato =$sql->fetch(PDO::FETCH_OBJ);

                
                $id = $_POST['id'];
                $statement = $db->getConnection()->prepare("DELETE FROM $this->table where id=:id");
                $statement->bindValue(':id', $id);
                $statement->execute();
                header("HTTP/1.1 200 OK");

                $res = array(
                    'mensaje'=> 'Registro eliminado satisfactoriamente',
                    'data' => array(
                        'idpro' =>  $dato->idpro ,
                        'artista' =>  $dato->artista,
                        'album' =>  $dato->album ,
                        'idC' =>  $dato->idC,
                        'fecha de entrada' =>  $dato->fechadeentrada ,
                        'fecha de salida' =>  $dato->fechadesalida,
                        'cantidad' =>  $dato->cantidad ,
                        'precio' =>  $dato->precio,
                        'correo'=> $dato->correo,
                    )
                );
                
                return $res;
            }
           
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

     // Actualiza un resgistro por Id
     public function update(){

        $db = new Dbase();
        try{
            
             //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([
                $_POST['id']
            ]);
            $result = $sql->rowCount();

            if ($result<=0) {
            $res = array("ID ". $_POST['id'] => "no exite registro");

            return $res;

            } else {
            
                $dato =$sql->fetch(PDO::FETCH_OBJ);

                $sql = "UPDATE $this->table SET artista = ?, album= ?, idC= ?, fecha de entrada= ?, fecha de salida= ?, cantidad= ?, precio= ?, correo= ?  WHERE ID= ? ";

                $statement = $db->getConnection()->prepare($sql);
                $statement->execute([
                    $_POST['artista'],
                    $_POST['album'],
                    $_POST['idC'],
                    $_POST['fecha de entrada'],
                    $_POST['fecha de salida'],
                    $_POST['cantidad'],
                    $_POST['precio'],
                    $_POST['correo'],
                    $_POST['idpro'],
                ]);

                header("HTTP/1.1 200 OK");

                $res = array(
                    'mensaje'=> 'Registro actualizado satisfactoriamente',
                    'data' => array(
                        'idpro' =>  $dato->idpro ,
                        'artista' =>  $dato->artista,
                        'album' =>  $dato->album ,
                        'idC' =>  $dato->idC,
                        'fecha de entrada' =>  $dato->fechadeentrada ,
                        'fecha de salida' =>  $dato->fechadesalida,
                        'cantidad' =>  $dato->cantidad ,
                        'precio' =>  $dato->precio,
                        'correo'=> $dato->correo,
                    )
                );

                return $res;
            }

        }catch(PDOException $e){
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
    public function productoId(){

        $db = new Dbase();

        try{
           
          
            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where id= ?");
            $sql->execute([$_GET['id']]);
            $result = $sql->rowCount();

           
            if ($result>=0) {
               
                //Mostrar un post
                $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where id=?");
                $sql->execute([
                    $_GET['id']
                ]);
                header("HTTP/1.1 200 OK");
                echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
                exit();
                
            
            }else{
                $res = array("ID ". $_GET['id'] => "no exite");

                return $res;
            }
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

}