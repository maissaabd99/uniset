<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Iset;
use App\Entity\Reponse;
use App\Entity\Support;
use App\Entity\Utilisateur;
use App\Form\AjoutsupportFormType;
use App\Form\EnseignantType;
use App\Form\EtudiantType;
use App\Form\IsetType;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\IsetRepository;
use App\Repository\MatiereRepository;
use App\Repository\PostRepository;
use App\Repository\ReponseRepository;
use App\Repository\SupportRepository;
use App\Repository\UtilisateurRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ConIsetsController extends AbstractController
{

    /**
     * @Route("consulterisets", name="consulterisets")
     * @param IsetRepository $repository
     * @return Response
     */
    public function index(IsetRepository $repository): Response
    {
        $properties = $repository->findAll();
        return $this->render('consulterisets.html.twig',['properties' => $properties]) ;


    }
    /**
     * @route("/Supprimeriset/{id}",name="Supprimeriset")
     * @param Iset $p
     * @return Response
     * @param UtilisateurRepository $repository
    * @param PostRepository $repository1
     * @param ReponseRepository $repository2

     */

    public function supprimer(Iset  $p,UtilisateurRepository $repository,PostRepository $repository1,ReponseRepository $repository2)
    {        $em = $this->getDoctrine()->getManager();

        foreach ($p->getClasses()  as $k) {
            foreach ($k->getEnsClasses() as $a) {
                $a->setEnseignant(null);
                $k->removeEnsClass($a);
             $em->remove($a);

            }
            foreach ($k->getEtudiants() as $b) {
                foreach ($b->getDeposers() as $c) {
                    $b->removeDeposer($c);
                    $c->setSupport(null);

                    $em->remove($c);
                }


                $u = $repository->findByUsername($b->getUsername());
                foreach ($u as $dd) {
                    foreach ($dd->getReponses() as $nn) {
                        $dd->removeReponse($nn);
                           $nn->setPost(null);
                           $em->remove($nn);
                    }
                   foreach ($dd->getPosts() as $i) {
                        $dd->removePost($i);
                        $em->remove($i);

                    }



                }
                $k->removeEtudiant($b);
                $em->remove($b);
                foreach ($u as $kk) {
                $em->remove($kk);
            }}
            $em->remove($k);

        }

            foreach (  $p->getEnseignants() as $f)
            {
                foreach ($f->getEnsMatieres() as $g)
            {
                $f->removeEnsMatiere($g);
                $g->setMatiere(null);
               $em->remove($g);
            }

                foreach ($f->getLibrairies() as $h)
                {
                    $f->removeLibrairy($h);
                    $em->remove($h);
                }

                $en = $repository->findByUsername($f->getUsername());

                foreach ($en as $x) {
                    foreach ($x->getReponses() as $l) {
                        $x->removeReponse($l);
                     $l->setPost(null);
                        $em->remove($l);
                    }
                    foreach ($x->getPosts() as $o) {

                        $x->removePost($o);

                         $em->remove($o);
                    }


                }

                $p->removeEnseignant($f);
                $em->remove($f);
                foreach ($en as $pk) {
                    $em->remove($pk);
                }

            }
$em->remove($p);
        $em->flush();
      
        $this->addFlash('success', 'Iset supprimé');



        return $this->redirect($_SERVER['HTTP_REFERER']);

    }








    /**
     * @Route("/isetdetail/{id}",name="isetdetail")
     * @param Iset $a
     * @param Request $request
     * @param IsetRepository $repository

     * @return Response
     */
    public function modifier(Iset $a, Request $request,IsetRepository $repository)
    {
        $form= $this->createForm(IsetType::class,$a);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('success', 'Nom Modifier');


            return $this->redirect($_SERVER['HTTP_REFERER']);
        }


        return $this->render('detailiset.html.twig',['a' =>$a,'form'=>$form->createView()]) ;

    }



    /**
     * @Route("/ajouteriset",name="ajouteriset")
     * @param Request $request
     * @param IsetRepository $repository


     * @return Response
     */
    public function ajouter(Request $request,IsetRepository $repository)
    {

        $iset= new Iset();
        $client = $repository->findAll();




        $form = $this->createForm(IsetType::class,  $iset);
        $form->handleRequest($request);

        $s = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist( $iset);
            $em->flush();

            $this->addFlash('success', 'Iset Ajouté');

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return $this->render('ajouteriset.html.twig', ['iset' =>  $iset, 'form' => $form->createView(),]);

    }


}