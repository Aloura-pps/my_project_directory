<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailService {

    private $mailer;

    private $params;

    public function __construct(ParameterBagInterface $params, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->params = $params;
        
    }


    public function SendMail($data, $to, $subject, $template) {

        // gerer l'envoie de mail

        $email = (new TemplatedEmail())
        ->from($this->params->get('app.mail_address'))
        ->to(new Address($to))
        ->subject($subject)

        // chemin vers le template twig
        ->htmlTemplate($template)
        ->context($data);

        $this->mailer->send($email);
    }

}

?>