<?php

include_once("./controllers/". $_GET['controller'] . "config.php");

$objController = "Controller" . ucfirst($_GET['controller']) ;


$controllador = new $objController();

$fun =  ucfirst($_GET['action']);
print_r($controllador->$fun()) ;