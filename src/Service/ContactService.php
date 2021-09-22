<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactService extends AbstractController
{

    private MailerInterface $mailer;
    private Environment $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer){

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    public function notify(Contact $contact)
    {

        $email = (new TemplatedEmail())
            ->from('noreply@agence.ca')
            ->to(new Address('contact@agence.ca'))
            ->subject('Wolf Company - Biens')
            ->replyTo($contact->getEmail())
            // path of the Twig template to render
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact,
                'name' => $contact->getProperty()->getTitle(),
                'name_link' => $contact->getProperty()->getSlug(),
                'firstName' => $contact->getFirstName(),
                'lastName' => $contact->getLastName(),
                'phone' => $contact->getPhone(),
                'userEmail' => $contact->getEmail(),
                'message' => $contact->getMessage()
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            die('Error while sending email' . $e->getMessage());
        }

    }
}