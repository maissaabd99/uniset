<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\AjoutsupportFormType;
use App\Repository\EnseignantRepository;
use App\Repository\IsetRepository;
use App\Repository\MatiereRepository;
use App\Repository\PostRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ForumController extends AbstractController
{
    /**
     * @Route("/forum_de_discussion", name="forum")
     * @param PostRepository $repository
     * @return Response
     */
    public function index(PostRepository $repository): Response
    {
        $posts=$repository->findAll();
        return $this->render('forum.html.twig',['posts'=>$posts]);
    }
}