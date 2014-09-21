<?php

namespace Ampersand\Passwordless\TokenDelivery;

use Ampersand\Passwordless\TokenDelivery\TokenDeliveryInterface;

class SwiftMailer implements TokenDeliveryInterface
{

    private $config = array();


    public function __construct( $config = array() )
    {
        $this->config = [
            'fromMail' => 'passwordless@localhost',
            'fromName' => 'Passwordless',
            'subject'  => 'Your access link',
            'template' => ''
        ];

        $this->config = array_merge($this->config, $config);
    }


    public function deliver( $token, $userId, $mail = '' )
    {
        // Create the message
        $message = \Swift_Message::newInstance()
          ->setSubject($this->config['subject'])
          ->setFrom(array($this->config['fromMail'] => $this->config['fromName']))
          ->setTo(array($mail))
          ->setBody('Login URL: http://localhost:8080/?user='.$userId.'&token='.$token);

        $transport = \Swift_SmtpTransport::newInstance( $this->config['smtpServer'], $this->config['smtpPort'], ($this->config['smtpUseSSL'] ? 'ssl' : '') )
          ->setUsername( $this->config['smtpUsername'] )
          ->setPassword( $this->config['smtpPassword'] );

        $mailer = \Swift_Mailer::newInstance($transport);

        return $mailer->send($message);
    }
}
