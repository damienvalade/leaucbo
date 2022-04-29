<?php

namespace App\EventSubscriber;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use App\Annotation\AddHeaders;
use Symfony\Component\HttpKernel\KernelEvents;

class SomethingAnnotationSubscriber implements EventSubscriberInterface
{
    private Reader $annotationReader;
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    public function onKernelController(ControllerEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        $this->handleController($controller);
    }

    /**
     * @param $controllers
     * @return void
     */
    private function handleController ($controllers)
    {
        list($controller, $name) = $controllers;

        try {
            $reflectionController = new \ReflectionClass($controller);
        }catch (ReflectionException $e){
            throw new \RuntimeException($e->getMessage());
        }

        $this->handleClassAnnotation($reflectionController);
    }

    public function handleClassAnnotation(ReflectionClass $controller) {
        $annotation = $this->annotationReader->getClassAnnotation($controller, AddHeaders::class);
        dd($controller->getAttributes());
        if ($annotation instanceof AddHeaders) {
            dd($annotation);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}