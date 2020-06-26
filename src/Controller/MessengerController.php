<?php
namespace App\Controller;
use App\Entity\SendNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;
use Symfony\Component\Routing\Annotation\Route;


class MessengerController extends AbstractController
{


    /**
     * @Route("/etudiant/messenger", name="messenger")
     * @param MessageBusInterface $bus
     * @return Response
     */
    public function messenger(MessageBusInterface $bus)
    {
       // $bus->dispatch(new SendNotification('maissa abdelwahed',['ajsdfhgjdter','kfhgfghj']));
        dd($bus);
        return $this->render('messenger.html.twig');
    }
}