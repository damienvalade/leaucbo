<?php

namespace App\Storage;

use Symfony\Component\Console\Style\SymfonyStyle;

interface StorageInterface
{
    /**
     * Archivage d'un ensemble de mesures atmosphériques sous forme de tableau dans un fichier texte au format JSON
     */
    public function saveArray(array $data, ?SymfonyStyle $io = null): void;

    /**
     * Archivage d'un ensemble de mesures atmosphériques sous forme de flux de données dans un index Elasticsearch
     */
    public function saveStream(\Generator $response, ?SymfonyStyle $io = null): void;

    /**
     * Définition du modèle de données correspondant à l'API consultée
     */
    public function setModel(string $model): StorageInterface;

    /**
     * Lecture du modèle de données correspondant à l'API consultée
     */
    public function getModel(): string;

    /**
     * Lecture de l'étiquette nommant le service
     */
    public function getName() : string;

    /**
     * Définition de l'étiquette du fragment JSON à conserver dans l'archive
     */
    public function setPath(string $path): StorageInterface;

    /**
     * Lecture dl'étiquette du fragment JSON à conserver
     */
    public function getPath(): string;
}
