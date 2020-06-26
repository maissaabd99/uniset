<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\EnsClasse;
use App\Entity\EnsMatiere;
use App\Entity\Matiere;
use App\Form\ClasseFormType;
use App\Form\MatiereFormType;
use App\Repository\ClasseRepository;
use App\Repository\EnsClasseRepository;
use App\Repository\EnseignantRepository;
use App\Repository\EnsMatiereRepository;
use App\Repository\EtudiantRepository;
use App\Repository\MatiereRepository;
use App\Repository\SupportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class Classe_ensController extends AbstractController
{
    /**
     * @Route("/enseignant/classes", name="mesclasses", methods={"GET"})
     * @param EnseignantRepository $repository
     * @param Request $request
     * @return Response
     */
    public function index(EnseignantRepository $repository,Request $request): Response
    {
        $user=$this->getUser();
        $classes=$user->getId();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $classes=$x->getEnsClasses();
        $classe=new Classe();
        $form=$this->createForm(ClasseFormType::class,$classe);
        $form->handleRequest($request);
        return $this->render('classes_ens.html.twig',['classes'=>$classes,'form'=>$form->createView()]);
    }

    /**
     * @Route("/enseignant/classe/add", name="addclasse")
     * @param EnseignantRepository $repository
     * @param Request $request
     * @return Response
     */
    public function addclasse(EnseignantRepository $repository,Request $request): Response
    {
        $user=$this->getUser();
        $classes=$user->getId();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $classes=$x->getEnsClasses();
        $classe=new Classe();
        $form=$this->createForm(ClasseFormType::class,$classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $enclasse= new EnsClasse();
            $em=$this->getDoctrine()->getManager();
            $classe->setNbrEtudiant(0);
            $classe->setIset($x->getIset());
            $em->persist($classe);
            $em->flush();
            $enclasse->setEnseignant($x);
            $enclasse->setClasse($classe);
            $em->persist($enclasse);
            $em->flush();


            return $this->redirectToRoute('mesclasses');
        }
        return $this->render('classes_ens.html.twig',['classes'=>$classes,'form'=>$form->createView()]);

    }

    /**
     * @Route("/enseignant/classe/delete/{id}", name="deleteclasse")
     * @param $id
     * @param EnseignantRepository $repository
     * @param Request $request
     * @param EnsClasseRepository $ensClasseRepository
     * @param ClasseRepository $rep
     * @return Response
     */
    public function delclasse($id,EnseignantRepository $repository,Request $request,EnsClasseRepository $ensClasseRepository,ClasseRepository $rep): Response
    {
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $em=$this->getDoctrine()->getManager();
        $cla=$rep->find($id);
        $em->remove($cla);
        $em->flush();
        return $this->redirectToRoute('mesmatieres');
    }

    /**
     * @Route("/enseignant/matieres", name="mesmatieres", methods={"GET"})
     * @param EnseignantRepository $repository
     * @param Request $request
     * @return Response
     */
    public function mesmatieres(EnseignantRepository $repository,Request $request): Response
    {
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $matieres=$x->getEnsMatieres();
        $matiere= new Matiere();
        $form=$this->createForm(MatiereFormType::class,$matiere);
        $form->handleRequest($request);

        return $this->render('matieres_ens.html.twig',['matieres'=>$matieres,'form'=>$form->createView()]);
    }

    /**
     * @Route("/enseignant/matiere/add", name="addmat")
     * @param EnseignantRepository $repository
     * @param Request $request
     * @return Response
     */
    public function addmatiere(EnseignantRepository $repository,Request $request): Response
    {
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $matiere= new Matiere();
        $form=$this->createForm(MatiereFormType::class,$matiere);
        $form->handleRequest($request);
        $ensmat = new EnsMatiere();
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();

            $em->persist($matiere);
            $em->flush();
            $ensmat->setMatiere($matiere);
            $ensmat->setEnseignant($x);
            $em->persist($ensmat);
            $em->flush();
            return $this->redirectToRoute('mesmatieres');
        }
        return $this->render('matieres_ens.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/enseignant/matiere/delete/{id}", name="deletemat")
     * @param $id
     * @param EnseignantRepository $repository
     * @param Request $request
     * @param EnsMatiereRepository $ensMatiereRepository
     * @param MatiereRepository $matrep
     * @return Response
     */
    public function delmatiere($id,EnseignantRepository $repository,Request $request,EnsMatiereRepository $ensMatiereRepository,MatiereRepository $matrep): Response
    {
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $matiere=$matrep->find($id);
        $em=$this->getDoctrine()->getManager();
        //$ensmat=$ensMatiereRepository->findOneBy(['matiere'=>$matiere,'enseignant'=>$x]);
       // $ensmat->
       // dd($ensmat);
        //$matiere->removeEnsMatiere($ensmat);
        $em->remove($matiere);
        $em->flush();
        return $this->redirectToRoute('mesmatieres');
    }

    /**
     * @Route("/enseignant/matiere/{id}/show_all_supports", name="showsupports")
     * @param $id
     * @param EnseignantRepository $repository
     * @param Request $request
     * @param EnsMatiereRepository $ensMatiereRepository
     * @param MatiereRepository $matrep
     * @return Response
     */
    public function showsupports($id,EnseignantRepository $repository,Request $request,EnsMatiereRepository $ensMatiereRepository,MatiereRepository $matrep): Response
    {
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $matiere=$matrep->find($id);
        $supports=$matiere->getSupports();
        return $this->render('show_supports.html.twig',['id'=>$id,'supports'=>$supports,'matiere'=>$matiere]);
    }


    /**
     * @Route("/enseignant/matiere/show_all_supports/{id}/show_deposers", name="showdeposers")
     * @param $id
     * @param EnseignantRepository $repository
     * @param SupportRepository $rep
     * @param EtudiantRepository $etudrep
     * @return Response
     */
    public function showdeposers($id,EnseignantRepository $repository,SupportRepository $rep,EtudiantRepository $etudrep): Response
    {
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $support=$rep->find($id);
        $matiere=$support->getMatiere();
        $deposers=$support->getDeposers();
        $totaletudiants= count($etudrep->findAll());
        $a= $support->getMatiere()->getEnsMatieres()->getValues();
      //  dd($a);
        return $this->render('show_deposers.html.twig',['id'=>$support->getMatiere()->getId(),'deposers'=>$deposers,'matiere'=>$matiere,'total'=>$totaletudiants]);
    }

}