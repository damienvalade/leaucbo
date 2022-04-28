<?php

namespace App\Controller;

use App\Entity\SaveHubeau;
use App\Repository\SaveHubeauRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\PdoAdapter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\DoctrineDbalAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SaveHubeauRepository $repo, CacheInterface $waterCache): Response
    {

        //Voir pour mettre les données en cache
        // $cache = new DoctrineDbalAdapter("mysql://root:@127.0.0.1:3306/usedwater?serverVersion=5.7&charset=utf8mb4");

        // $save = $cache->getItem('blop');
        
        // if (!$save->get()) {
        //     $datas = $repo->findBy([], [], 10);
        //     $save->set($datas);
        //     $save->expiresAfter(3600);
        //     $cache->save($save);
        // }        

        $value = $waterCache->get('waterData', function (ItemInterface $item) use ($repo) {
            $datas = $repo->findBy([], [], 10);
            $item->expiresAfter(600);
        
            // ... do some HTTP request or heavy computations
        
            return $datas;
        });
        

        return $this->render('home/index.html.twig', [
            'datas' => $value
        ]);
    }
}
