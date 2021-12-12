<?php
$Data=(array)json_decode(file_get_contents("php://input"));
//просто выдать токен и добавить его в бд + 4-значное число которое должен прислать пользователь
require_once "Validation/Validation.php";
require_once "Validation/message.php";




//$Data=['phone'=>"12342","name"=>"asdfa"];
$db= new PDO("mysql:host=localhost;dbname=crud", "root","" );
$validaton=new Validation();

$validaton->getConnectionToDb($db);

$data=$validaton->createNote($Data['phone'],300);
$data["name"]=$Data["name"];
$validaton->sendMessage(new message(),$data);