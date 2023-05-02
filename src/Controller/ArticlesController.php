<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    // mose REST
    //je récupere tout les articles
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }

    // route multiples
    // je récupere un article
    #[Route('/article/{id}', name: 'show_article_by_id', requirements: ['id' =>'\d+'])]
    public function showArticle(EntityManagerInterface $entityManager, string $id): Response
    {
        // récuperer l'article en bdd avec l'id de mon article
        // comment récuperer l'id (qui est paramétrer dans l'url)
        // => je récupère le paramètre id via l'argument $id

        $article = $entityManager->getRepository(Articles::class)->findBy(["id" => $id])[0];

        // Les trois articles les plus récents liés à cette category
        // different de l'article en cours
        // => on va devoir coder la requête dans ArticleRepository

        $relatedArticles = $entityManager->getRepository(Articles::class)->findLastTreeRelatedArticles($article->getCategory(), $id);

        // dd($relatedArticles);



        return $this->render('articles/article.html.twig', [
            'article' => $article,
            'relatedArticles' => $relatedArticles

        ]);
    }

    // Cette méthode permet d'afficher tous les articles liés à une catégorie

    #[Route('/articles/{id}', name: 'show_articles_by_category', requirements: ['id' =>'\d+'])]
    public function showArticlesByCategory(EntityManagerInterface $entityManager, string $id): Response
    {
        // récuperer tous les articles liés à l'id catégorie récupéré sur la route
        // comment récupérer l'id de la catégorie

        $articles = $entityManager->getRepository(Articles::class)->findBy(["category" => $id]);

        $category = $entityManager->getRepository(Category::class)->find($id);



        return $this->render('articles/index.html.twig', [
            'listArticles' => $articles,
            'category' => $category
        ]);
    }
}
