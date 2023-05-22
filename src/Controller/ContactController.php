<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]

    // un controleur attend des requete et renvoie une reponse
    // le nom index que l'on choisi  signifie que c'est la fonction principale
    public function index(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, MailService $mailService): Response
    {
        // j'ai creer le formulaire à partir de l'instance de la classe contact 
        // car mon formulaire est lié à la class Contact
        $contact = new Contact();
        // la classe contact est instanciée car je peux initialiser des valeurs à mes champs
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);


        // Si vous voulez afficher les erreurs ou vous voulez (sous le champ par defaut)

        // if ($form->isSubmitted()) {

        //     $errors = $validator->validate($contact);

        //     if (count($errors) > 0) {
        
        //         return $this->render('contact/index.html.twig', [
        //             'contact_form' => $form,
        //             'errors' => $errors,
        //         ]);
        //     }
        // }

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();

            // gerer l'envoie de mail

            $mailService->sendMail(
                [
                    'firstName' => $contact->getFirstName(),
                    'name' => $contact->getLastName(),
                    'message' => $contact->getMessage()
                ],
                $contact->getEmail(),
                'Message de contact',
                'emails/signup.html.twig'
            );

            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);

            $this->addFlash('confirmation', 'votre email a bien été envoyé !');

        }
            // ... perform some action, such as saving the task to the database

            // return $this->redirectToRoute('contact/index.html.twig');
        

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form,


        ]);
    }


}
