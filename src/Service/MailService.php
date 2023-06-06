<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailService {

    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function SendMail($data, $to, $subject, $template) {

        // gerer l'envoie de mail

        $email = (new TemplatedEmail())
        ->from('guillaume.perona@aloura-dev.fr')
        ->to(new Address($to))
        ->subject($subject)

        // chemin vers le template twig
        ->htmlTemplate($template)
        ->context($data);

        $this->mailer->send($email);
    }

}

?>