<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticlesType;
use App\Form\RegistrationFormType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleCtrlController extends AbstractController
{
    #[Route('/article/new', name: 'new_article')]
    public function articless(Request $request, ArticleRepository $articleRepository)
    {   // nouvelle article dans variable
        $article = new Article();
        // variable abstract créer newFrom lié au repo articleType et prends la variable article
        $form = $this->createForm(ArticlesType::class, $article);
        // ecoute avec handle request ($request) methode GET POST
        $form->handleRequest($request);
        // si le formulaire et creer envoyer et validé  alors
        if ($form->isSubmitted() && $form->isValid()) {
            $dateNow = new \DateTime('now');
            $article
                ->setActive(true)
                ->setDateDeCreation($dateNow);
            $articleRepository->add($article);

            return $this->redirectToRoute('articles');
        }
        // abstract (boite) renvoi vers un twig
        return $this->render('article_ctrl/index.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    #[Route('/articles', name: 'articles')]
    public function Articles(ArticleRepository $articleRepository)
    {
        $articlez = $articleRepository->findBy(array('active' => true));

        return $this->render('article_ctrl/articles.html.twig', [
            'articlez' => $articlez
        ]);


    }

    #[Route('/articles/article/{id}', name: 'articleLike', methods: ['GET', 'POST'])]
    public function articleLike(ArticleRepository $articleRepository, $id, )
    {

        $arti = $articleRepository->findOneBy(['id' => $id]);
        $arti->addType();
        dd('toto');

    // si lutilisateur est inculs dans la table de jointure alors
        if ($type=$this->getUser()) {

            $arti->addType();



        } else {
           // $arti->findOneBy->removeType();

        }

        return $this->render('article_ctrl/article.html.twig', [
            'arti' => $arti
        ]);

    }
}
