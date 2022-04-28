<?php

namespace App\Storage;

use App\Service\ClientRequestService;
use Doctrine\ORM\EntityManagerInterface;
use JsonMachine\Items;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

class FileStorage implements StorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var SerializerInterface
     */
    protected $on;

    protected ClientRequestService $clientRequestService;

    protected $model;
    protected $path;
    protected $name;

    public function __construct(
        EntityManagerInterface $em,
        SerializerInterface $on,
        ClientRequestService $clientRequestService
    ) {
        $this->em = $em;
        $this->on = $on;
        $this->name = self::NAME;
        $this->clientRequestService = $clientRequestService;
    }

    /**
     * Etiquette pour nommer le service
     */
    const NAME = 'file';

    /**
     * Définition du modèle de données des mesures atmosphériques
     * Soit 'indices' (indicateurs de pollution), soit 'pollution' (épisodes de pollution)
     */
    public function setModel(string $model): StorageInterface
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setPath(string $path): StorageInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Archivage d'un ensemble de mesures atmosphériques sous forme de tableau dans un fichier texte au format JSON
     */
    public function saveArray(array $data = null, ?SymfonyStyle $io = null): void
    {
    }

    public function saveStream(\Generator $response, ?SymfonyStyle $io = null): void
    {
        // TODO: Implement saveStream() method.
    }
}
