<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Iset;
use App\Entity\Librairie;
use App\Form\LibType;
use App\Repository\DeposerRepository;
use App\Repository\EnseignantRepository;
use App\Repository\LibrairieRepository;
use App\Repository\PostRepository;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;


class EnseignantController extends AbstractController
{
    /**
     * @Route("/enseignant", name="enst")
     * @param EnseignantRepository $repository
     * @return Response
     */
    public function index(EnseignantRepository $repository): Response
    {

        $user = $this->getUser();
        $x = $repository->findOneBy(['username' => $user->getUsername()]);
        $matieres = $x->getEnsMatieres();
        $classes = $x->getEnsClasses();
        return $this->render('enseignant.html.twig', ['matieres' => $matieres, 'classes' => $classes]);
    }

    /**
     * @Route("enseignants", name="enseignants")
     * @param EnseignantRepository $repository
     * @return Response
     */
    public function consulter(EnseignantRepository $repository): Response
    {


        $x = $repository->findAll();


        return $this->render('enseignants.html.twig', ['x' => $x]);
    }

    /**
     * @route("/Supprimerens/{id}",name="Supprimerens")
     * @param Enseignant $p
     * @param UtilisateurRepository $repository
     * @param PostRepository $repository1
     * @param ReponseRepository $repository2
     * @return Response
     */

    public function supprimer(Enseignant $p, UtilisateurRepository $repository, PostRepository $repository1, ReponseRepository $repository2)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($p->getIset()->getClasses() as $k) {
            foreach ($k->getEnsClasses() as $a) {
                if ($a->getEnseignant()->getId() == $p->getId()) {
                    $a->setEnseignant(null);
                    $k->removeEnsClass($a);
                    $em->remove($a);
                }
            }
        }
        foreach ($p->getEnsMatieres() as $g) {
            $p->removeEnsMatiere($g);
            $g->setMatiere(null);
            $em->remove($g);
        }
        foreach ($p->getLibrairies() as $h) {
            $p->removeLibrairy($h);
            $em->remove($h);
        }
        $en = $repository->findByUsername($p->getUsername());
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
        foreach ($en as $pk) {
            $em->remove($pk);
        }
        $p->getIset()->removeEnseignant($p);
        $em->flush();
        $this->addFlash('success', 'Enseignant supprimé');
        return $this->redirect($_SERVER['HTTP_REFERER']);

    }

    /**
     * @route("/enseignant/matiere/show_all_supports/show_deposers/{id}",name="noter_travail")
     * @param $id
     * @param DeposerRepository $repository
     * @return Response
     */

    public function noter_travail($id,DeposerRepository $repository):Response

    {
        $depot=$repository->find($id);
        return $this->render('noter.html.twig',['depot'=>$depot] );

    }


    /**
     * @route("/enseignant/matiere/show_all_supports/show_deposers/{id}/noter",name="noter")
     * @param $id
     * @param Request $request
     * @param DeposerRepository $repository
     * @return RedirectResponse
     */

    public function noter($id,Request $request,DeposerRepository $repository)
    {
        $value=$request->request->get('note') ;
      //  dd($value);
        $depot=$repository->find($id);
       // dd($depot);
        $depot->setNote(floatval($value));
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('showsupports',['id'=>$depot->getSupport()->getMatiere()->getId()]);
//


    }
}