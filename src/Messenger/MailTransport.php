<?php

namespace App\Messenger;
use Swift_Mailer;
use Swift_SmtpTransport;

class MailTransport implements Transport
{
 public function transport($message){
     $configs = require('config.php');
     //Creating connection with gmail services and sending letters
     $transport = (new Swift_SmtpTransport($configs['mail']['host'], $configs['mail']['port'], $configs['mail']['encryption']))
         ->setUsername($configs['mail']['username'])
         ->setPassword($configs['mail']['password']);
     $mailer = new Swift_Mailer($transport);
     $mailer->send($message);
 }
}