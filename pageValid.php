<?php
//получение урл с кодом для верификакции + токет пользователя
//выполнить если валидный
//

require_once "Validation/Validation.php";
require_once "Validation/message.php";


$Data=(array)json_decode(file_get_contents("php://input"));

$db= new PDO("mysql:host=localhost;dbname=crud", "root","" );
$validaton=new Validation();
$validaton->getConnectionToDb($db);



echo json_encode(array('answer'=>$validaton->getAndValidCode($Data['id_order'],$Data['code'])));