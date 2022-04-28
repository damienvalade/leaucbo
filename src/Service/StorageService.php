<?php

namespace App\Service;

use App\Entity\SaveHubeau;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class StorageService
{
    private string $localStorage;
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer, string $localStorage)
    {
        $this->serializer = $serializer;
        $this->em = $em;
        $this->localStorage = $localStorage;
    }

    public function execute(array $results, bool $isDbStorage)
    {
        if (!$isDbStorage) {
            file_put_contents($this->localStorage . '/public/results/results.json', json_encode($results));
        } else {
            $data = $results['data'];

            foreach ($data as $datum) {
                $result = $this->serializer->deserialize(json_encode($datum), SaveHubeau::class, 'json');
                $this->em->persist($result);
            }

            $this->em->flush();
        }
    }
}
