<?php

class message implements SendMessage
{


    public function sendMessage(array $data){
    extract($data);
        $forLog="Number phone:$phone; Name:$name; VerifyCode:$code\n";
        file_put_contents("MustBeSend.txt",$forLog,FILE_APPEND);
    }
}