<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class afficherMembres extends AbstractController
{
    #[Route('/membres', name: 'membres', methods: ['GET','POST'])]
    public function users(UserRepository $UserRepository)
    {

        $users = $UserRepository->findAll();

        return $this->render('afficherMembre.html.twig', [
            'users'=>$users
        ]);
    }


}