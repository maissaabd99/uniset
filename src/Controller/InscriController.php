<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InscriController extends AbstractController
{


    /**

     * @Route("/inscri", name="inscri")
     */
    public function home()
    {

        return $this->render('inscri.html.twig');


    }
}