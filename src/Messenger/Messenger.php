<?php
namespace App\Messenger;

interface Messenger
{
public function send(string $nameTemplate, array $params, array $users);
public function render(string $template, array $params);
}