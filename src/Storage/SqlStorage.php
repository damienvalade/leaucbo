<?php

namespace App\Storage;

use App\Entity\SaveHubeau;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

class SqlStorage implements StorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var SerializerInterface
     */
    protected $on;

    protected $model;
    protected $path;
    protected $name;

    public function __construct(EntityManagerInterface $em, SerializerInterface $on)
    {
        $this->em = $em;
        $this->on = $on;
        $this->name = self::NAME;
    }

    /**
     * Etiquette pour nommer le service
     */
    const NAME = 'sql';

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
    public function saveArray(array $data, ?SymfonyStyle $io = null): void
    {
        $data = $data['data'];

        foreach ($data as $sample) {
            try {
                $entity = $this->deserialize($sample);
                $this->em->persist($entity);
            } catch (\Exception $e) {
                $this->em->flush();
                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        }
        $this->em->flush();
    }

    private function deserialize(array $data)
    {
        return $this->on->deserialize(\json_encode($data), SaveHubeau::class, 'json', ['disable_type_enforcement' => true]);
    }

    public function saveStream(\Generator $response, ?SymfonyStyle $io = null): void
    {
        // TODO: Implement saveStream() method.
    }
}
