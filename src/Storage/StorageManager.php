<?php

namespace App\Storage;


final class StorageManager
{
    protected $handlers = [];

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->handlers[$handler->getName()] = $handler;
        }
    }

    public function getHandlers() : array
    {
        return $this->handlers;
    }

    public function getHandler(string $handler, string $model): StorageInterface
    {
        if (!array_key_exists($handler, $this->handlers)) {
            throw new \Exception("Aucun pilote {$handler} n’est prévu pour sauvegarder les données");
        }

        $storeHandler = $this->handlers[$handler];
        $storeHandler->setModel($model);

        return $storeHandler;
    }
}
