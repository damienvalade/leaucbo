<?php

namespace App\Controller;

use App\Repository\SaveHubeauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Annotation\AddHeaders;

#[AddHeaders(name: 'Salut')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SaveHubeauRepository $repo): Response
    {
        //Voir pour mettre les données en cache
        $cache = new FilesystemAdapter;

        $datas = $repo->findBy([], [], 10);

        return $this->render('home/index.html.twig', [
            'datas' => $datas
        ]);
    }
}
