<?php

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Support;
use App\Form\AdministrateurType;
use App\Form\AjoutsupportFormType;
use App\Form\EnseignantType;
use App\Form\EtudiantType;
use App\Repository\AdministrateurRepository;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\IsetRepository;
use App\Repository\MatiereRepository;
use App\Repository\SupportRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ModifierController extends AbstractController
{

    /**
     * @Route("compte", name="compte")
     * @param Request $request
     * @param EnseignantRepository $repository
     * @param EtudiantRepository $repository1
     * @param AdministrateurRepository $repository2

     * @return Response
     */
    public function index(Request $request,EnseignantRepository $repository,EtudiantRepository $repository1,AdministrateurRepository $repository2): Response
    {

        if($this->getUser()->getType()=='e')
        {
        $b=new Enseignant();
        $b=  $repository->findOneBy(['username'=>$this->getUser()->getUsername()]);
        $form= $this->createForm(EnseignantType::class,$b);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $this->getUser()->setImg($b->getImg());
            $this->getUser()->setUsername($b->getUsername());
            $this->getUser()->setPassword($b->getPassword());
            $this->getUser()->setCin($b->getCin());
            $this->getUser()->setUpdatedAt($b->getUpdatedAt());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->getUser()->setImg($b->getImg());
            $this->getUser()->setUpdatedAt($b->getUpdatedAt());
            $em->flush();
            $this->addFlash('success', 'Coordonnées modifié');

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
            return $this->render('compte.html.twig',['b' =>$b,'form'=>$form->createView()]) ;
        }
        else{
            if($this->getUser()->getType()=='s') {
                $k = new Etudiant();
                $k = $repository1->findOneBy(['username' => $this->getUser()->getUsername()]);
                $form = $this->createForm(EtudiantType::class, $k);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $this->getUser()->setImg($k->getImg());
                    $this->getUser()->setUsername($k->getUsername());
                    $this->getUser()->setPassword($k->getPassword());
                    $this->getUser()->setUpdatedAt($k->getUpdatedAt());

                    $this->getUser()->setCin($k->getCin());
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    $this->getUser()->setImg($k->getImg());
                    $this->getUser()->setUpdatedAt($k->getUpdatedAt());
                    $em->flush();
                    $this->addFlash('success', 'Coordonnées modifié');

                    return $this->redirect($_SERVER['HTTP_REFERER']);
                }
                return $this->render('compte.html.twig', ['k' => $k, 'form' => $form->createView()]);
            }
            else{

                $l = new Administrateur();
                $l = $repository2->findOneBy(['username' => $this->getUser()->getUsername()]);
                $form = $this->createForm(AdministrateurType::class, $l);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $this->getUser()->setUpdatedAt($l->getUpdatedAt());
                    $this->getUser()->setImg($l->getImg());
                    $this->getUser()->setUsername($l->getUsername());
                    $this->getUser()->setPassword($l->getPassword());
                    $this->getUser()->setCin($l->getCin());


                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    $this->getUser()->setImg($l->getImg());
                    $this->getUser()->setUpdatedAt($l->getUpdatedAt());
                    $em->flush();
                    $this->addFlash('success', 'Coordonnées modifié');

                    return $this->redirect($_SERVER['HTTP_REFERER']);
                }
                return $this->render('compte.html.twig', ['l' => $l, 'form' => $form->createView()]);

            }
        }





    }

}