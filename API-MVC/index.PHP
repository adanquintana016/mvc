<?php

class Dbase{
    private $host;
    private $dbase_name;
    private $username;
    private $password;
    private $charset;

    public function __construct(){
        $this->host     = 'localhost';
        $this->dbase_name   = 'cliente';
        $this->username     = 'root';
        $this->password     = '';
        $this->charset  = 'utf8mb4';
    }

    function getConnection(){

        try {
            
            // DEBUG ERROR BD
            $option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false];

            $conn = new PDO("mysql:host=" . $this->host 
                            . ";dbname=" . $this->dbase_name 
                            . ";charset=" . $this->charset
                            ,$this->username
                            ,$this->password
                            ,$option);

                            return $conn;

        } catch (PDOException $e) {

            print_r("Error connection : " . $e->getMessage());
        }

    }
}


//include_once("./controllers/". $_GET['controller'] . "config.php");

//$objController = "Controller" . ucfirst($_GET['controller']) ;


//$controllador = new $objController();

//$fun =  ucfirst($_GET['action']);
//print_r($controllador->$fun()) ;