<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')] // annotation// je map l'url /home
    // si j'ai une url /home => j'éxecute index()
    //injecter dans la classe index la dépendance vers EntityManagerInterface
    public function index(EntityManagerInterface $entityManager): Response // le retour de la méthode index() est un objet de type réponse
    // index() va intercepter une requête et retrouver une réponse
    // en php 8 on peut typer la retour des méthodes
    {


        // j'ai récupéré le repository de la classe Articles
        // et j'ai appelé la méthode findAll()
        $articles = $entityManager->getRepository(Articles::class)->findAll();
        $categories = $entityManager->getRepository(Category::class)->findAll();


        // elle retourne l'appel à la méthode render()
        // render() => renvoit une vue
        // avec un tableau de paramètres
        

        return $this->render('home/index.html.twig', [
            'listCategories' => $categories, // je passe des paramètres à ma vue
            'listArticles' => $articles
        ]);
    }
}
