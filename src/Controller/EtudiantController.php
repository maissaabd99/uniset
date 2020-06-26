<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Iset;
use App\Repository\EnsClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\PostRepository;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etud", methods={"GET"})
     * @param EtudiantRepository $etudiantRepository
     * @param EnsClasseRepository $r
     * @return Response
     */
    public function index(EtudiantRepository $etudiantRepository,EnsClasseRepository $r): Response
    {
        $et= $etudiantRepository->findOneBy(['username'=>$this->getUser()->getUsername()]);
        $classe=$et->getClasse();
        $c=$r->find($classe->getId());
        $en=$classe->getEnsClasses()->getValues();
        return $this->render('etudiant.html.twig',['etud'=>$et,'res'=>$en,'depots'=>$et->getDeposers()->getValues()]);
    }


    /**
     * @route("/Supprimeretd/{id}",name="Supprimeretd")
     * @param Etudiant $p
     * @return Response
     * @param UtilisateurRepository $repository
     * @param PostRepository $repository1
     * @param ReponseRepository $repository2

     */

    public function supprimer(Etudiant $p,UtilisateurRepository $repository,PostRepository $repository1,ReponseRepository $repository2)
    {        $em = $this->getDoctrine()->getManager();
                foreach ($p->getDeposers() as $c) {
                    $p->removeDeposer($c);
                    $c->setSupport(null);
                    $em->remove($c);
                }
                $u = $repository->findByUsername($p->getUsername());
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
                $p->getClasse()->removeEtudiant($p);
                $em->remove($p);
                foreach ($u as $kk) {
                    $em->remove($kk);
                }
        $em->flush();
        $this->addFlash('success', 'Etudiant supprimé');
        return $this->redirect($_SERVER['HTTP_REFERER']);

    }
    /**
     * @Route("etudiants", name="etudiants")
     * @param EtudiantRepository $repository
     * @return Response
     */
    public function consulter(EtudiantRepository $repository): Response
    {
        $x=$repository->findAll();
        return $this->render('etudiants.html.twig',['x'=>$x]);
    }


}