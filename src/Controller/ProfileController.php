<?php

namespace App\Controller;

use App\Repository\BlagueRepository;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(BlagueRepository $blagueRepository): Response
    {
        return $this->render('profile/index.html.twig', [
            'blagues' => $blagueRepository->findBy(['profile'=>$this->getUser()->getProfile()]),
        ]);
    }
}
