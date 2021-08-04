<?php
namespace App\Messenger;

interface Transport
{
 public function transport($message);
}