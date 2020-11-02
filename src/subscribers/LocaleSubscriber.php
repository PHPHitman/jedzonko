<?php

namespace App\subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface{

    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event){
        $request = $event->getRequest();

        if(!$request->hasPreviousSession()){
            return;
        }

        if($locale=$request->attributes->get('_locale', $this->defaultLocale)){

        }
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST=> [['onKernelRequest', 17]]
        ];
    }
}