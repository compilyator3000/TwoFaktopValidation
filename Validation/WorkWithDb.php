<?php
require_once "CreateNote.php";
class  WorkWithDb
{
    private static string $TEMP_VALID_DATA;
    //проверяем существует ли таблица в бд
    public  function checkExistTable(PDO $dbname, $nameTable)
    {


        $res = $dbname->prepare("SHOW TABLES FROM `crud` LIKE '$nameTable'");
         $res->execute();
        $res = $res->fetchAll(PDO::FETCH_ASSOC);
        WorkWithDb::$TEMP_VALID_DATA=$nameTable;
       // var_dump($res);
        return $res;
    }



//создание таблицы для хранения кодов
     function  createTable(PDO $db){
        $temp=WorkWithDb::$TEMP_VALID_DATA;
        $sql=$db->prepare("CREATE TABLE `$temp` (id VARCHAR (50) NOT null,
     code int(4) not null,
     timestamp varchar(30) not null,
      phone varchar(30) not null,
      PRIMARY KEY(id))");
        $sql->execute();


    }

//получить 4-значный код и метку времени до которого код валидный
    public static function getKeyAndTime(PDO $db,string $id){
        $temp=WorkWithDb::$TEMP_VALID_DATA;
        $sql= $db->prepare("select `code`,`timestamp`from `$temp` where id=:id");
        $sql->bindParam('id',$id);
        $sql->execute();

        $data=$sql->fetchAll(PDO::FETCH_ASSOC);
        if($data==null){
            return 0;
        }
        return $data;
    }
//создать запись в таблице про попытку подтвержения
    public  function setNote($db, string $phone,int $timeoflivecode){
        $createNote=new CreateNote();
        $id=$createNote->generate_string();
        $code=rand(1000,9999);
        $temp=WorkWithDb::$TEMP_VALID_DATA;
        $sql= $db->prepare("insert into  `$temp`(`id`,`code`,`phone`,`timestamp`) values (:id,:code,:phone,:timestamp)");
        $mac=["id"=>$id,"code"=>$code,"phone"=>$phone,"timestamp"=>$timeoflivecode];

        if($sql->execute($mac)!=PDO::ERR_NONE){
            return -1;
        }

        return $mac ;

    }
    //удалет запись, выполняется после успешной верификации
    public  function removeNote($db, string $id){
        $temp=WorkWithDb::$TEMP_VALID_DATA;
        $sql= $db->prepare("DELETE FROM `$temp` WHERE id=:id");
        $sql->bindParam('id',$id);
        $sql->execute();
    }



}