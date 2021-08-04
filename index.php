<?php

use App\Messenger\MailMessenger;

require_once __DIR__.'/vendor/autoload.php';


$user = ['oleg2455553535@gmail.com', 'oleg2455553535@gmail.com'];
$params = require_once('params.php');

$mailer = new MailMessenger();

$result = $mailer->send('the_order_in_processing', $params, $user);
