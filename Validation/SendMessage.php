<?php
//интерфейс отправки сообщения
interface SendMessage
{
public function sendMessage(array $data);
}