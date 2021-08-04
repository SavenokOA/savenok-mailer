<?php

namespace App\Messenger;
use Swift_Message;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class MailMessenger implements Messenger
{
    public function send(string $nameTemplate, array $params, array $users) : bool
    {   // Create the logger
        $logger = new Logger('MailMessenger');

        // Now add some handlers
        $logger->pushHandler(new StreamHandler(__DIR__.'/mailing.log', Logger::INFO));
        $logger->pushHandler(new FirePHPHandler());

        $configs = require('config.php');
        // Create the template
        $template =$this->render($nameTemplate, $params);

        // Create a message
        $message = (new Swift_Message($nameTemplate))
            ->setFrom([$configs['mail']['username'] => 'Knife Shop'])
            ->setTo($users)
            ->addPart($template, 'text/html');

        //Create transport with various method. You can change method to templates in config file, if this method contains in class Mail Transport
        $sending = new MailTransport;
        $transpotringMethod = $configs['mail']['transportingMethod'];
        $sending->$transpotringMethod($message);
        $logger->info('Sending email to '. implode(" | ", $users) . ' with ' .$nameTemplate .' subject.');

        return true;
    }

    public function render(string $template, array $params)
    {
        $configs = require('config.php');

        // You can change path to templates in config file
        if (file_exists($configs['mail']['templatePath']. $template . '.php')) {
            ob_start();
            extract($params);
            require $configs['mail']['templatePath'] . $template . '.php';
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        } else {
            echo 'Template not exist';
        }
    }
}