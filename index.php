<?php
require_once "Validation/Validation.php";
require_once "Validation/message.php";


$validaton=new Validation();
$db= new PDO("mysql:host=localhost;dbname=crud", "root","" );
//var_dump($db);

$validaton->getConnectionToDb($db);
//$data=$validaton->createNote("0661890956",100);
//$data["name"]="sanya";
//$validaton->sendMessage(new message(),$data);
var_dump($validaton->getAndValidCode("aEBUP09NXMpRSwt7",8044));//getUserIdenKey


