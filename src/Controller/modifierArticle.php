<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticlesType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;


#[Route('/article')]
class modifierArticle extends AbstractController
{
    #[Route('/update/{id}', name: 'update')]
     public function update(ArticleRepository $articleRepository , $id, Request $request)
     {
         $arti= $articleRepository->findOneBy(['id'=>$id]);

         // variable abstract créer newFrom lié au repo articleType et prends la variable article
         $form = $this->createForm(ArticlesType::class, $arti);
         // ecoute avec handle request ($request) methode GET POST
         $form->handleRequest($request);
         // si le formulaire et creer envoyer et validé  alors
         if ($form->isSubmitted() && $form->isValid()) {
             $dateNow = new \DateTime('now');
             $arti
                 ->setActive(true)
                 ->setDateDeCreation($dateNow)
             ;
             $articleRepository->add($arti);

             return $this->redirectToRoute('articles');
         }
         // abstract (boite) renvoi vers un twig
         return $this->render('article_ctrl/update.html.twig', [
             'formulaire'=>$form->createView()
         ]);



     }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(ArticleRepository $articleRepository, $id )
    {
        //recupere un id
        $arti= $articleRepository->findOneBy(['id'=>$id]);
        //avec l'id trouver l'article correspondant
        //utiliser la function remove qui se trouve dans le articlerepository et lui passer en param l'article a supprimer
        $del = $articleRepository->remove($arti);
        if ($del = true){
            return $this->redirectToRoute('articles');


        }
        //redirection vers l'affichage de tout tes articles


    }

    #[Route('/activeUnactive', name: 'activeUnactive')]
    public function activeUnactive()
    {
        dd('active');
    }
    #[Route('/avis/{id}', name: 'avis')]
    public function avis(ArticleRepository $articleRepository, $id)
    {
       $arti= $articleRepository->findOneBy(['id'=>$id]);
        // {'id':article.id}

        return $this->render('article_ctrl/note.html.twig',[
            'arti'=>$arti
        ]);

    }
}