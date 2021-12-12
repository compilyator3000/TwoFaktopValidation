<?php
require_once "WorkWithDb.php";
require_once "CreateNote.php";
require_once "SendMessage.php";

class Validation
{
    //получения метки текущего времени, желательно переопределить
    function getTime(){
        return time();
    }


    static public object $connectToDb;//edit



    public function getConnectionToDb(object $ob) {//тут может промисать что интрефейс

        Validation::$connectToDb=$ob;

        $db=new WorkWithDb();
        if($db->checkExistTable(Validation::$connectToDb,"temp_valid_data")==null){
            $db->createTable(Validation::$connectToDb);
        }
    }



//валидация кода подтверджения
    public function getAndValidCode(string $id,string $code) {
        $db=new WorkWithDb();
        //дать пользователю ключ
        $res=WorkWithDb:: getKeyAndTime(Validation::$connectToDb,$id)[0];
      //  var_dump($res);
        if($res['timestamp'] >=$this->getTime()) {
            $db->removeNote(Validation::$connectToDb, $id);
            if ($res['code'] == $code  ){

                $this->What_I_Must_do_if_all_is_cool();
                return 1;
            }
        }
        return 0;

    }


//создадим запись
    public function createNote(string $phone,int $timeOfliveCode) {
        //дать пользователю ключ

        $ob=new WorkWithDb();


        return $ob->setNote(Validation::$connectToDb,$phone,$this->getTime()+$timeOfliveCode);

    }
//отправить сообщение
    function sendMessage(SendMessage $obj,array $data){
        $obj->sendMessage($data);
        $this->What_I_Must_do_if_all_is_cool(); // убрать

    }

//переоперделение что должна делать функция после успешной валидации кода подтверджения
    public function What_I_Must_do_if_all_is_cool(){}




}


