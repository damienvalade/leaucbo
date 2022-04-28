<?php

namespace App\Controller;

use App\Repository\SaveHubeauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SaveHubeauRepository $repo): Response
    {
        //Voir pour mettre les données en cache
        $datas = $repo->findBy([], [], 10);

        return $this->render('home/index.html.twig', [
            'datas' => $datas
        ]);
    }
}
